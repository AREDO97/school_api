<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\StudentClass;
use App\Models\User;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    // enroll into class
    public function create(User $student)
    {
        // check if student is eligible for enrollment
        $studentResults=$student->results;
        $studentAverage=$studentResults->avg('marks');
        $studentClass=$student->studentClass;
        // all classes
        $allClasses=StudentClass::where('id','>',$studentClass->id)->first();
        if( $studentAverage<90){
            return response()->json([
                'message'=>'Student not eligible to be enrolled to '. $allClasses->name
            ]);
        }
        $currentEnrollment=$student->enrollments()->where('status','active')->first();
        //enroll student
       $newEnrollment= Enrollment::Enroll($student->id,$currentEnrollment->class_id + 1,$currentEnrollment->year_id + 1);
       // update
        $currentEnrollment->update([
            'status'=>'completed'
        ]);
        return response()->json([
            'student_enrollment'=>$currentEnrollment,
            'new_enrollment'=>$newEnrollment
        ]);
    }
    // class enrollments
    public function classEnrollments(Request$request,StudentClass $class)
    {
        $classEnrollments=$class->enrollments;
        return response()->json($classEnrollments);
    }
    public function classEnrollment(Request $request,StudentClass $class)
    {
        $classEnrollments=$class->enrollments()->where('year_id',$request->year_id)->first();
        return response()->json($classEnrollments);
    }
}
