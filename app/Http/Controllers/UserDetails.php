<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Alumnni;
use App\Faculty;
use App\User;
use Illuminate\Http\Request;

class UserDetails extends Controller
{
    public function info($email){
        $faculty=Faculty::where('email',$email)->first();
        $student=User::where('email',$email)->first();
        $alumni=Alumnni::where('email',$email)->first();
        $admin=Admin::where('email',$email)->first();

        if ($faculty){
            return response()->json(['user'=>$faculty]);
        }elseif ($alumni){
            return response()->json(['user'=>$alumni]);
        }elseif ($student){
            return response()->json(['user'=>$student]);
        }elseif ($admin){
            return response()->json(['user'=>$admin]);
        }
    }
}
