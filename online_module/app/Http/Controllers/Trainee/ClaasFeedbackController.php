<?php

namespace App\Http\Controllers\Trainee;

use App\Models\Subjects;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClaasFeedbackController extends Controller
{
    public function index(Request $request ){

        $course_id = $request->input('course_id');

        $subjects = Subjects::with('topics')
                    ->where('course_id', $course_id)
                    ->orderBy('sl_no', 'ASC')
                    ->get();

        return view('trainee.feedbackAllTopics',compact('subjects'));
    }
}
