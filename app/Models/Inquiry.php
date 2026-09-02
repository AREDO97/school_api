<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inquiry extends Model
{
    // allowed
      use HasFactory;
    protected $fillable = [
        'user_id',
        'message',
        'title',
        'phone',
        'status'
    ];
    // user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // replies
        // replies
    public function replies()
    {
        return $this->hasMany(InquiryReply::class);
    }
    }
