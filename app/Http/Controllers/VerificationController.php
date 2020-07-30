<?php

namespace App\Http\Controllers;

use App\Alumnni;
use App\Faculty;
use App\Notifications\Emailverification;
use App\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    protected function SetUser($id){
        $user=User::where('activation_token', $id)->first();
        $faculty = Faculty::where('activation_token', $id)->first();
        $alumni = Alumnni::where('activation_token', $id)->first();
        if ($user){
            return $user;
        }
        if ($faculty){
            return $faculty;
        }
        if ($alumni){
            return $alumni;
        }
        else{
            return false;
        }
    }
    public function verify($token) {

        $user=$this->SetUser($token);
        if (!$user) {
            return response()->json([
                'msg' => 'This activation token is invalid.'
            ], 404);
        }
        $user->email_verified_at=now();
        $user->active=true;
        $user->activation_token = '';
        $user->save();

        return response()->json([
            'msg' => 'Account verify Successfully'
        ]);
    }
    protected function checkUser($email){
        $user=User::where('email', $email)->first();
        $faculty = Faculty::where('email', $email)->first();
        $alumni = Alumnni::where('email', $email)->first();
        if ($user){
            return $user;
        }
        if ($faculty){
            return $faculty;
        }
        if ($alumni){
            return $alumni;
        }
        else{
            return false;
        }
    }
    public function resend(Request $request) {
        $user=$this->checkUser($request->email);
        if ($user->active) {
            return response()->json(["msg" => "Email already verified."], 400);
        }

        $user->notify(
            new Emailverification($user)
        );

        return response()->json(["msg" => "Email verification link sent on your email id"]);
    }
}
