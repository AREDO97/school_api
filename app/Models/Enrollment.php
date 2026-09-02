<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    // allowed
    protected $fillable = [
        'class_id',
        'student_id',
        'year_id',
        'status'
    ];
    // student
    public function student()
    {
        return $this->belongsTo(User::class);
    }
    // class 
    public function studentClass()
    {
        return $this->belongsTo(studentClass::class);
    }
    // academic years
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
    // create enrollment
    public static function Enroll($student_id,$class_id,$year_id)
    {
        $enrollment=self::create([
        'student_id'=>$student_id,
        'class_id'=>$class_id,
        'year_id'=>$year_id
    ]);
    return $enrollment;
    }
}
