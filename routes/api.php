<?php

use App\Http\Controllers\api\classController;
use App\Http\Controllers\api\EnrollmentController;
use App\Http\Controllers\api\InquiryController;
use App\Http\Controllers\api\InquiryReplyController;
use App\Http\Controllers\api\NotificationsController;
use App\Http\Controllers\api\ResultController;
use App\Http\Controllers\api\StudentController;
use App\Http\Controllers\auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// register user
Route::post('/register',[AuthController::class,'register'])
->name('register');
// login user
Route::post('/login',[AuthController::class,'login'])
->name('login');
// log out endpoint
Route::post('/logout',[AuthController::class,'logout'])
->middleware('auth:sanctum')->name('logout');

// student results
Route::get('/student/results',[ResultController::class,'studentScore'])
->middleware('auth:sanctum')->name('student results');
// all results
Route::get('/results',[ResultController::class,'index'])
->middleware('auth:sanctum')->name('results');
// course results
Route::get('course/results/{course}',[ResultController::class,'courseResults'])
->middleware('auth:sanctum')->name('course results');
// user result
Route::get('/user/result',[ResultController::class,'userResult'])
->middleware('auth:sanctum')->name('user results');
// student position
Route::get('/student/position',[ResultController::class,'studentPosition'])
->middleware('auth:sanctum')->name('student position');
// enrollment
Route::get('/class/enrollment/{class}',[classController::class,'classEnrollment'])
->middleware('auth:sanctum')->name('class enrollment');
// unenrollStudent
Route::patch('/unenroll/{user}',[classController::class,'unenrollStudent'])
->middleware('auth:sanctum')->name('unenroll user');
// enroll to class
Route::patch('/class/enroll/{class}',[classController::class,'enroll'])
->middleware('auth:sanctum')->name('enroll user');
// class marks
Route::get('/class/marks/{class}',[classController::class,'classMarks'])
->middleware('auth:sanctum')->name('class scores');
// class average
Route::get('/class/{class}/average',[ResultController::class,'classAverage'])
->middleware('auth:sanctum')->name('class average');

// student enrollment
Route::get('/student/enrollment/{student}',[EnrollmentController::class,'create'])
->middleware('auth:sanctum')->name('enroll student');
//classEnrollments
Route::get('/class/{class}/enrollments',[EnrollmentController::class,'classEnrollments'])
->middleware('auth:sanctum')->name('class enrollments');
//class enrollment by year
Route::get('/class/{class}/enrollment',[EnrollmentController::class,'classEnrollment'])
->middleware('auth:sanctum')->name('class enrollment by year');

// inquiry create
Route::post('/inquiry/create',[InquiryController::class,'create'])
->middleware('auth:sanctum');
 // view inquiry
 Route::get('/inquiries',[InquiryController::class,'index'])
->middleware('auth:sanctum');

// notifications management
Route::middleware(['auth:sanctum', 'role:admin,super_admin,user'])->group(function () {
   
  // mark notifications as read
  Route::post('/notifications/markAsRead', [ NotificationsController::class, 'markAllAsRead'])
  ->name('marks as read');
  // delete notifications
  Route::delete('/notification/delete/{id}',[NotificationsController::class,'destroy'])
  ->name('delete notification');
});



Route::middleware(['auth:sanctum', 'role:admin,super_admin,user'])->group(function () {
// inquiry reply
Route::post('/inquiry/{inquiry}/reply',[InquiryReplyController::class,'replyInquiry']);
});
 // all user notifications
  Route::get('/notifications', [NotificationsController::class,'index'])
  ->name('all notifications')->middleware('auth:sanctum');
// access one inquiry
Route::get('/inquiry/{inquiry}/access',[InquiryController::class,'accessOneInquiry'])
->middleware('auth:sanctum');




Route::middleware(['auth:sanctum','role:admin,super_admin'])->group(function(){
// all students
Route::get('/students/all',[StudentController::class,'allStudents']);
// create student
Route::post('/student/create',[StudentController::class,'create']);
// delete student
Route::post('/student/{user}/delete',[StudentController::class,'destroy']);
// hard delete
Route::delete('/student/{user}/destroy',[StudentController::class,'delete']);

});

// update user info
Route::post('/student/{user}/update',[StudentController::class,'update'])
->middleware('auth:sanctum');