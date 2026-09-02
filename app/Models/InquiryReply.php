<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryReply extends Model
{
    //
    protected $fillable = [
        'user_id',
        'inquiry_id',
        'reply',
        'status'
    ];
    // user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // inquiry
    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }
}
