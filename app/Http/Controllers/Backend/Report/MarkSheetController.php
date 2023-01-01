<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\StudentMarks;
use App\Models\ExamType;
use App\Models\StudentClass;
use App\Models\StudentYear;
use App\Models\MarksGrade;
use Illuminate\Support\Facades\Auth;


class MarkSheetController extends Controller
{
    public function MarkSheetView(){

    	$data['years'] = StudentYear::orderBy('id','desc')->get();
    	$data['classes'] = StudentClass::all();
    	$data['exam_type'] = ExamType::all();
    	return view('backend.report.marksheet.marksheet_view',$data);

    }

    public function MarkSheetViewSingular(){

        $data['years'] = StudentYear::orderBy('id','desc')->get();
        $data['exam_type'] = ExamType::all();
        return view('backend.report.marksheet.marksheet_view_singular',$data);

    }


    public function MarkSheetGetSingular(Request $request){
        $id = Auth::user()->id;
        $year_id = $request->year_id;
        $exam_type_id = $request->exam_type_id;

        $count_fail = StudentMarks::with(['student_class','year'])->where('student_id',$id)->where('year_id',$year_id)->where('exam_type_id',$exam_type_id)->where('marks','<','33')->get()->count();
        // dd($count_fail);
        $singleStudent = StudentMarks::where('year_id',$year_id)->where('exam_type_id',$exam_type_id)->where('student_id',$id)->first();
        if ($singleStudent == true) {

            $allMarks = StudentMarks::with(['student_class','year'])->where('exam_type_id',$exam_type_id)->where('year_id',$year_id)->where('student_id',$id)->get();
            // dd($allMarks->toArray());
            $allGrades = MarksGrade::all();
            return view('backend.report.marksheet.marksheet_pdf',compact('allMarks','allGrades','count_fail'));

        }else{

            $notification = array(
                'message' => 'Sorry These Criteria Does not match',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }


    } // end Method

    public function MarkSheetGet(Request $request){

    	$year_id = $request->year_id;
    	$class_id = $request->class_id;
    	$exam_type_id = $request->exam_type_id;
    	$id_no = $request->id_no;

    $count_fail = StudentMarks::where('year_id',$year_id)->where('class_id',$class_id)->where('exam_type_id',$exam_type_id)->where('id_no',$id_no)->where('marks','<','33')->get()->count();
    	// dd($count_fail);
    $singleStudent = StudentMarks::where('year_id',$year_id)->where('class_id',$class_id)->where('exam_type_id',$exam_type_id)->where('id_no',$id_no)->first();
    if ($singleStudent == true) {

    $allMarks = StudentMarks::with(['assign_subject','year'])->where('year_id',$year_id)->where('class_id',$class_id)->where('exam_type_id',$exam_type_id)->where('id_no',$id_no)->get();
    	// dd($allMarks->toArray());
    $allGrades = MarksGrade::all();
    return view('backend.report.marksheet.marksheet_pdf',compact('allMarks','allGrades','count_fail'));

    }else{

    	$notification = array(
    		'message' => 'Sorry These Criteria Does not match',
    		'alert-type' => 'error'
    	);

    	return redirect()->back()->with($notification);
       }


    } // end Method





}
