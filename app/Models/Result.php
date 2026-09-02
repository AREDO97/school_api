<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    //
    protected $fillable = [
        'student_id',
        'course_id',
        'marks',
        'status'
    ];
    // student
    public function student()
    {
        return $this->belongsTo(User::class,'student_id');
    }
    // course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    // grade
    public  static function grade($mark)
    {
        if($mark>=80){
            $grade='D1';
        }
        elseif($mark>=75){
            $grade='D2';
        }
        elseif($mark>=65){
            $grade='C3';
        }
        elseif($mark>=50){
            $grade='P8';
        }
        else{
            $grade='F9';
        }
        return $grade;
    }

    // comment
     // grade
    public  static function comment($mark)
    {
        if($mark>=80){
            $comment='Excellent';
        }
        elseif($mark>=75){
            $comment='Very Good';
        }
        elseif($mark>=65){
            $comment='Good';
        }
        elseif($mark>=50){
            $comment='Fair';
        }
        else{
            $comment='Poor';
        }
        return $comment;
    }
}
