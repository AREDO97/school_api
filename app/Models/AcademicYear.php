<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    // allowed
    protected $fillable = [
        'academic_year'
    ];

    // enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class,'year_id');
    }
}
