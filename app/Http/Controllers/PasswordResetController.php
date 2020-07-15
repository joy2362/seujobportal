<?php

namespace App\Http\Controllers;
use App\Alumnni;
use App\Faculty;
use App\User;
use App\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use Carbon\Carbon;
use Notification;

class PasswordResetController extends Controller
{

    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $faculty = Faculty::where('email', $request->email)->first();
        $alumni = Alumnni::where('email', $request->email)->first();
        $student = User::where('email', $request->email)->first();

        if ($faculty ){
           $user=$faculty;
        }elseif ($alumni){
            $user=$alumni;
        }elseif ($student){
            $user=$student;
        }else{
            return response()->json([
                'message' => 'We cant find a user with that e-mail address.'
            ], 404);
        }

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => Str::random(60)
             ]
        );
        if ($user && $passwordReset)
            $user-> notify(
                new PasswordResetRequest($passwordReset->token)
            );

        return response()->json([
            'message' => 'We have e-mailed your password reset link!'
        ]);
    }

    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        }
        return response()->json($passwordReset->email);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'token' => 'required|string'
        ]);
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        $faculty = Faculty::where('email', $passwordReset->email)->first();
        $alumni = Alumnni::where('email', $passwordReset->email)->first();
        $student = User::where('email', $passwordReset->email)->first();
        if ($faculty ){
            $user=$faculty;
        }elseif ($alumni){
            $user=$alumni;
        }elseif ($student){
            $user=$student;
        }else{
            return response()->json([
                'message' => 'We cant find a user with that e-mail address.'
            ], 404);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));
        return response()->json([
            'message' => 'Password Changed Successfully!'
        ]);
    }
}
