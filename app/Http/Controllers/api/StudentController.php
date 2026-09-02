<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    // all students
    public function allStudents()
    {
            $students=User::where('role','student')->get();
            // response
            return response()->json($students);
    }
    // create student
    public function create(Request $request)
    {
        $defaultPassword="ivan256@@";
        $user=User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($defaultPassword),
        'role'=>'student'
        ]);
        // response
        return response()->json([
            'message'=>'student created successifully',
            'student'=>$user
        ],201);
    }
    // update student
    public function update(Request $request,User $user)
    {
        $owner=$request->user();
        if($owner->id !== $user->id){
            abort(403,'Unauthorised');
        }
        $user->update([
            'name'=>$request->name ?? $user->name,
            'email'=>$request->email ?? $user->email
        ]);
        // response
        return response()->json([
            'message'=>'student info updated',
            'student'=>$user
        ]);
    }
    // delete student
    public function destroy(Request $request,User $user)
    {

        $admin=$request->user();
        if($admin->role !== 'admin' && $admin->role !== 'super_admin'){
                abort(403,'unauthorised');
        }
        // update user status
        $user->update([
            'status'=>'inactive'
        ]);
        // response
        return response()->json([
            'message'=>'student deleted successifully',
            'student'=>$user
        ]);
    }

    // hard delete student
    public function delete(Request $request,User $user)
    {
        
        $admin=$request->user();
        if($admin->role !== 'admin' && $admin->role !== 'super_admin'){
                abort(403,'unauthorised');
        }
        $user->delete();
        // response
        return response()->json([
            'message'=>'user deleted successifully'
        ]);
    }

}
