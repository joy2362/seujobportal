<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function verify(Request $request){
        $user=Admin::where('email',$request->email)->first();
        if ($user){
            if (Hash::check($request->password, $user->verify)){
                return response()->json(['message'=>'Access Granted']);
            }else{
                return response()->json(['message'=>'Access Denied'],404);
            }
        }else{
            return response()->json(['message'=>'Access Denied'],404);
        }
    }
}
