<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    //
    protected $fillable = [
        'name'
    ];
    // students
    public function students()
    {
        return $this->hasMany(User::class,'class_id');
    }
    // promotion class
    public static function promoted($class)
    {
        if($class=='Primary 1'){
            $newclass='Primary 2';
        }
        elseif($class=='Primary 2'){
            $newclass='Primary 3';
        }
        elseif($class=='Primary 3'){
            $newclass='Primary 4';
        }
        elseif($class=='Primary 4'){
            $newclass='Primary 5';
        }
        elseif($class=='Primary 5'){
            $newclass='Primary 6';
        }
        elseif($class=='Primary 6'){
            $newclass='Primary 7';
        }
        return $newclass;
    }

    // enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class,'class_id');
    }
}
