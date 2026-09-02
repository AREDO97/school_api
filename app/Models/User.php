<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Result;

#[Fillable(['name', 'email', 'password','status','role','class_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // results
    public function results()
    {
        return $this->hasMany(Result::class,'student_id');
    }
    // class
    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class,'class_id');
    }
    // enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class,'student_id');
    }
    // inquiries
    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }
    // replies
    public function replies()
    {
        return $this->hasMany(InquiryReply::class);
    }
}
