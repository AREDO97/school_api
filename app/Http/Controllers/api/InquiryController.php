<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\User;
use App\Notifications\inquiryNotification;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    // create inquiry
    public function create(Request $request)
    {
        // user
        $user=$request->user();
       $inquiry = Inquiry::create([
            'user_id'=>$user->id,
            'phone'=>$request->phone,
            'message'=>$request->message,
            'title'=>$request->title
        ]);

        // send notification
        $users=User::whereIn('role',['admin','super_admin'])->get();
        foreach($users as $user){
            $user->notify(
        new inquiryNotification($user->name,$inquiry->title)
            );
        }
        // response 
        return response()->json([
            'message'=>'Inquiry submitted successifully',
            'inquiry'=>$inquiry
        ],201);
    }

    // all inquiries 
    public function index()
    {
        $inquiry=Inquiry::latest()->paginate(10);
        // response
        return response()->json($inquiry);
    }

    // get one inquiry
    public function accessOneInquiry(Inquiry $inquiry)
    {
        return response()->json($inquiry);
    }
    
}
