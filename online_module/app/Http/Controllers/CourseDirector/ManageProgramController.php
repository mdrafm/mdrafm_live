<?php

namespace App\Http\Controllers\CourseDirector;

use App\Models\programsVC;
use App\Models\CourseMudels;
use Illuminate\Http\Request;
use App\Models\trineePrograms;
use App\Models\TrainingModules;
use App\Models\TrainingPrograms;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class ManageProgramController extends Controller
{
    public function index(){
        $modules = TrainingModules::all();
        $programs = TrineePrograms::with(['module', 'course'])->get();
        return view('courseDirector.manageProgram',['modules'=>$modules,'programs'=>$programs]);
    }

    public function getAllCourse(Request $request){

       $moduleId = $request->input('moduleId');
       $courses = CourseMudels::where('module_id',$moduleId)->get();
       return response()->json($courses);
    }
    public function getAllPrograms(Request $request){

        $courseId = $request->input('courseId');
        $programs = TrainingPrograms::where('course_id',$courseId)->get();
        return response()->json($programs);
     }

     public function getAllDates(Request $request){

        $courseId = $request->input('courseId');
        $startDate = $request->input('start_date');

        // if (!$programId || !$startDate) {
        //     return response()->json(['error' => 'Program ID and Start Date are required'], 400);
        // }

        try {
            // Fetch the program details
            $courses = CourseMudels::find($courseId);

            if (!$courses) {
                return response()->json(['error' => 'Program not found'], 404);
            }

           // Parse the start date using Carbon
        $startDateCarbon = \Carbon\Carbon::parse($startDate);

        // Calculate the end date based on the program duration
        $endDate = $startDateCarbon->copy()->addDays($courses->duration)->format('Y-m-d');

        // Calculate enrollment start and end dates
        $enrollStartDate = $startDateCarbon->copy()->subDays(7)->format('Y-m-d');
        $enrollEndDate = $startDateCarbon->copy()->subDays(1)->format('Y-m-d');


            return response()->json([

                'start_date' => $startDate,
                'end_date' => $endDate,
                'enroll_start_date' => $enrollStartDate,
                'enroll_end_date' => $enrollEndDate
            ], 200);

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }

     }

     public function saveProgram(Request $request){

        $validator = Validator::make($request->all(),[
            'module_id' => 'required',
            'course_id' => 'required',
            'start_date'=>'required',
            'end_date' => 'required',
            'en_start_date' => 'required',
            'en_end_date' => 'required',
            'vc1_date' => 'required',
            'vc2_date' => 'required',
            'pd_date' => 'required',
            'exam_date' => 'required'
         ]);

         if($validator->passes()){
            try {
                DB::beginTransaction();

            $programs = new trineePrograms();
            $programs->module_id = $request->input('module_id');
            $programs->course_id = $request->input('course_id');

            $programs->start_date = $request->input('start_date');
            $programs->end_date = $request->input('end_date');
            $programs->en_start_date = $request->input('en_start_date');
            $programs->en_end_date = $request->input('en_end_date');
            $programs->pd_date = $request->input('pd_date');
            $programs->exam_date = $request->input('exam_date');
            $programs->status = 1;
            $programs->save();


            // Save VC-1 Date as a separate record (if provided)
            if ($request->filled('vc1_date')) {
                $vc1Date = new programsVC();
                $vc1Date->program_id = $programs->id;
                $vc1Date->vc_date = $request->input('vc1_date');
                $vc1Date->description = 'VC-1 Date'; // Optional: Adding a description
                $vc1Date->save();
            }

            // Save VC-2 Date as a separate record (if provided)
            if ($request->filled('vc2_date')) {
                $vc2Date = new programsVC();
                $vc2Date->program_id = $programs->id;
                $vc2Date->vc_date = $request->input('vc2_date');
                $vc2Date->description = 'VC-2 Date'; // Optional: Adding a description
                $vc2Date->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Program and VC dates saved successfully.',
                'program_id' => $programs->id
            ], 201);

            }
            catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while saving the program.',
                    'error' => $e->getMessage()
                ], 500);
            }
         }
     }

}
