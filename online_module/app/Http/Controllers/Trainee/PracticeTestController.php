<?php

namespace App\Http\Controllers\Trainee;

use auth;
use App\Models\Topics;
use App\Models\PracticeTest;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use App\Models\PracticeQuestions;
use App\Models\UserPracticeTestAns;
use App\Http\Controllers\Controller;
use App\Models\PracticeQuestionOptions;

class PracticeTestController extends Controller
{
    public function index(Request $request){

        if ($request->has('program_id')) {
            // If program_id is present in the request, store it in the session
            session(['program_id' => $request->program_id]);
        } else {
            // If program_id is not present in the request, retrieve it from the session
            $programId = session('program_id');
        }

        // Retrieve the program_id from the session or request
        $programId = session('program_id', $request->program_id);

        $tests = PracticeTest::with('programs','subject')
                 ->where('program_id',$programId)
                 ->get();

        $userId = auth()->id();

        //check exam status already given or not
        $examStatus = UserPracticeTestAns::where('user_id', $userId)
                      ->where('status', 1)
                      ->pluck('exam_id') // Get the IDs of tests already taken
                      ->toArray();

        // Check if the user has completed all topics for the subject
        $allCompleted = UserProgress::where('user_id', $userId)
            ->where('subject_id', $request->subject_id)
            ->where('status', 1)
            ->count() === Topics::where('subject_id', $request->subject_id)->count();


        return view('trainee.praticeTestList',compact('tests','allCompleted', 'examStatus'));
    }

    public function showReesult(Request $request ){
        $userId = auth()->id();
        $examId = $request->testId;

        // Get all questions for the exam
       $examData = PracticeTest::where('id', $examId)->first();
    //    $response = [
    //     'query' => $examData->toSql(),
    //     'bindings' => $examData->getBindings(),
    // ];

     //return response()->json($examData);
    // Count correct answers
    $correctAnswers = UserPracticeTestAns::where('user_id', $userId)
        ->where('exam_id', $examId)
        ->where('is_correct', true)
        ->count();

    // Count incorrect answers
    $incorrectAnswers = UserPracticeTestAns::where('user_id', $userId)
        ->where('exam_id', $examId)
        ->where('is_correct', false)
        ->count();

    // Count unanswered questions
    $answeredQuestions = UserPracticeTestAns::where('user_id', $userId)
        ->where('exam_id', $examId)
        ->where('status', 1)
        ->count();
    $unansweredQuestions = $examData->total_question - $answeredQuestions;

    return response()->json([
        'status' => 'success',
        'total_questions' => $examData->total_question,
        'eachWriteAns'=>$examData->mark_per_right_ans,
        'eachWrongAns'=>$examData->mark_per_wrong_ans,
        'correct_answers' => $correctAnswers ,
        'incorrect_answers' => $incorrectAnswers,
        'unanswered_questions' => $unansweredQuestions,
        'final_answer'=> $correctAnswers * $examData->mark_per_right_ans - $incorrectAnswers * $examData->mark_per_wrong_ans
    ]);

    }

    public function startTest(Request $request){


//dd($request);
      $subject_id = $request->subject_id;
      $exam_duration = $request->exam_duration;
      $mark_per_right_ans = $request->mark_per_right_ans;
      $marks_per_wrong_answer = $request->marks_per_wrong_answer;
      $marks_per_wrong_answer = $request->marks_per_wrong_answer;
      $total_question = $request->total_question;
      $test_id = $request->test_id;
      $userId = auth()->id();
        return view('trainee.startTest',
        compact('exam_duration','userId','mark_per_right_ans','marks_per_wrong_answer','total_question','subject_id','test_id'));
    }

    public function fetchQuestions(Request $request){

        $questions = PracticeQuestions::with('options')
                    ->where('subject_id',$request->subjectId)
                    ->limit($request->total_question)
                    ->get();
        return response()->json($questions);
    }

    public function saveAnswer(Request $request){
        $userId = auth()->id(); // Get the logged-in user ID
        $questionId = $request->question_id;
        $selectedOption = $request->answer;
        $test_id = $request->test_id;

        // Fetch the correct answer from the options table
        $correctOption = PracticeQuestionOptions::where('question_id', $questionId)
            ->where('is_correct', true)
            ->first();

        $isCorrect = $correctOption->option_label === $selectedOption;

        // Save the user's answer
        UserPracticeTestAns::updateOrCreate(
            ['exam_id'=>$test_id,'user_id' => $userId, 'question_id' => $questionId],
            [
                'selected_option' => $selectedOption,
                'is_correct' => $isCorrect,
                'status'=>1
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Answer saved successfully',
            'question_id' => $questionId,
        ]);
    }
}
