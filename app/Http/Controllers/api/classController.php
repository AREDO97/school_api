<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\StudentClass;
use App\Models\User;

use Illuminate\Http\Request;

class classController extends Controller
{
    // class students
    public function classEnrollment(StudentClass $class)
    {
        $enrollment=$class->students;
        // response
        return response()->json([
            'class'=>$class->name,
            'enrollment'=>$enrollment
        ]);
    }
    // unenroll student
    public function unenrollStudent(User $user)
    {
        $user->update([
            'class_id'=>null
        ]);
        return response()->json([
            'message'=>'Student unenrolled',
            'student'=>$user
        ]);
    }
    // enroll
    public function enroll(StudentClass $class)
    {
        $user=auth()->user();
        $user->update([
            'class_id'=>$class->id
        ]);
        // response
        return response()->json([
            'message'=>'Enrollment successiful',
            'class'=>$class->name,
            'user'=>$user,
            
        ]);
    }
    // class student marks
    public function classMarks(StudentClass $class)
    {
        $class_students=$class->students;
        $array=[];
        foreach($class_students as $student){
            $results=$student->results;
            $results=$results->map(function ($result){
               return [
                 'student_mark'=>$result->marks,
               ];
            });
        $array[]=[
            'student_name'=>$student->name,
            'student_email'=>$student->email,
            'results'=>$results
            ];
        }

        
        return response()->json([
            'array'=>$array,
        ]);
    }
}
