<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\InquiryReplyMail;
use App\Models\InquiryReply;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Mail;
use App\Notifications\InquiryReplyNotification;
use Illuminate\Http\Request;

class InquiryReplyController extends Controller
{
    //inquiry id, user-id rpely

    // reply to an inquiry
    public function replyInquiry(Request $request, Inquiry $inquiry)
    {
        $user=$inquiry->user;
       $reply = InquiryReply::create([
            'user_id'=>$user->id,
            'inquiry_id'=>$inquiry->id,
            'reply'=>$request->reply
        ]);

        // send notification
        $user->notify(
            new InquiryReplyNotification($reply->reply)
        );

        // send email
        Mail::to($user->email)->send(
            new InquiryReplyMail($reply->reply)
        );
        // response
        return response()->json([
            'message'=>'Reply sent successifully',
            'reply'=>$reply,
            'inquiry'=>$inquiry
        ]);
    }
}
