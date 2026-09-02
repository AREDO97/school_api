<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\StudentClass;
use App\Models\User;


class ResultController extends Controller
{
    // student results
    public function studentScore()
{
    $student = auth()->user();

    // This student's results
    $results = $student->results;

    // This student's total
    $total = $results->sum('marks');

    // Calculate every student's total
    $studentTotals = Result::all()
        ->groupBy('student_id')
        ->map(function ($results) {
            return $results->sum('marks');
        })
        ->sortDesc();

    // Find this student's position
    $position = $studentTotals
        ->keys()
        ->search($user->id);

    $position = $position + 1;

    // Transform individual results
    $results = $results->map(function ($result) {
        return [
            'course_name' => $result->course->name,
            'course_mark' => $result->marks,
            'course_grade' => $result->grade(),
            'comment'=>Result::comment($result->marks)
        ];
    });

    return response()->json([
        'student_name' => $student->name,
        'total' => $total,
        'position' => $position,
        'results' => $results,
    ]);
}
    // all results
    public function index()
    {
        $results=Result::all();
        $results=$results->map(function ($result) {
            return [
                'student'=>$result->student->name,
                'class_name'=>$result->student->studentClass->name,
                'course'=>$result->course->name,
                'marks'=>$result->marks,
                'grade'=>Result::grade($result->marks),
                'comment'=>Result::comment($result->marks)
            ];
        });
        return response()->json($results);
    }
    // course results
    public function courseResults(Course $course)
    {
        $results=$course->results;

        $output=$results->map(function ($result){
            return [
                'student_name'=>$result->student->name,
                'course_mark'=>$result->marks,
                'grade'=>Result::grade($result->marks),
                'comment'=>Result::comment($result->marks)
            ];
        });
        return response()->json([
            'course_name'=>$course->name,
            'details'=>$output
        ]);
    }
    
    public function studentPosition()
{
    $student = auth()->user();
    $studentResults=$student->results;
    // 1. Get my results
    $myResults = $student->results;
    $output =$myResults->map(function ($result){
        return [
        'course'=>$result->course->name,
        'course_marks'=>$result->marks,
        'grade'=>Result::grade($result->marks),
        'comment'=>Result::comment($result->marks)
        ];
    });

    // 2. Calculate my total
    $myTotal = $myResults->sum('marks');
    $myAverage=floor($myResults->avg('marks'));
    // promotion message
    // student class
    $studentClass=$student->studentClass->name;
    $newClass=StudentClass::promoted($studentClass);


    // year of study
   $yearStudy=$student->enrollments()->where('status','active')->first();
   $year=$yearStudy->year_id;
    if($myAverage>=50){
        $message='Your promoted to '. $newClass;
        $student->update([
            'class_id'=>$student->studentClass->id + 1
        ]);
        // create a new enrollment to next year
        $enrollment=Enrollment::Enroll($student->id,$student->studentClass->id + 1,$year + 1);
        // update enrollment
       $yearStudy->update([
            'status'=>'completed'
       ]);
    }
    else{
        $message='Your adviced to repeat '. $studentClass;
    }
    // 3. Start position at 1
    $position = 1;

    // 4. Get all students
    $students = User::all();

    // 5. Compare their totals with mine
    foreach ($students as $otherStudent) {

        // Don't compare me with myself
        if ($otherStudent->id == $student->id) {
            continue;
        }

        // Calculate this student's total
        $otherTotal = $otherStudent->results->sum('marks');

        // Did they score more than me?
        if ($otherTotal > $myTotal) {
            $position++;
        }
    }

    return response()->json([
        'student' => $student->name,
        'student_class'=>$studentClass,
        'position' => $position,
        'results'=>$output,
        'total' => $myTotal,
        'average_mark'=>$myAverage,
        'message'=>$message,
        //'enrollments'=> $yearStudy
    ]);
}

// class average
public function classAverage(StudentClass $class)
{
    $classStudents=$class->students;
    $results=[];
    foreach($classStudents as $student){
        $results[]= [
            'student_results'=>$student->results
        ];
    }
  
    return response()->json([
        'total_students'=>$classStudents->count(),
        
    ]);
}
}
