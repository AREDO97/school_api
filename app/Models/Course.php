<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Result;

class Course extends Model
{
    //allowed
    protected $fillable = [
        'name'
    ];
    // results
    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
