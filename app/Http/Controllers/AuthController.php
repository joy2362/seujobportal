<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Alumnni;
use App\Faculty;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function me(Request $request)
    {
        $faculty=Faculty::where('email',$request->email)->first();
        $student=User::where('email',$request->email)->first();
        $admin=Admin::where('email',$request->email)->first();
        $alumni=Alumnni::where('email',$request->email)->first();
        if($faculty){
            $credentials = request(['email', 'password']);

            if (! $token = auth('faculty')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->faculrtyrespondWithToken($token);
        }
        elseif ($student){
            $credentials = request(['email', 'password']);

            if (! $token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->studentrespondWithToken($token);
        }
        elseif ($admin){
            $credentials = request(['email', 'password']);

            if (! $token = auth('admin')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->adminrespondWithToken($token);
        }
        elseif ($alumni){
            $credentials = request(['email', 'password']);

            if (! $token = auth('alumni')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->alumnirespondWithToken($token);
        }
        else{
            return response()->json(['error' => 'nouser'], 401);
        }
    }

    protected function faculrtyrespondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>  auth('faculty')->factory()->getTTL() * 60
        ]);
    }
    protected function studentrespondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>  auth('api')->factory()->getTTL() * 60
        ]);
    }
    protected function adminrespondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>  auth('admin')->factory()->getTTL() * 60
        ]);
    }
    protected function alumnirespondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>  auth('alumni')->factory()->getTTL() * 60
        ]);
    }

    public function teacherreg(Request $request){
        $validatedData = $request->validate([
            'name'=>'required',
            'email'=>'required|unique:faculties','users',
            'password'=>'required',
            'image'=>'required'
        ]);

        $ext = $request->file('image')->extension();
        $name=Str::random(10).".".$ext;
        $img=Image::make($request->image)->resize(250,250);
        $upload='asset/img/faculty';
        $img_name=$upload.'/'.$name;
        $img->save($img_name);

        $user=new Faculty;
        $user->name =$request->name;
        $user->user_type = "2";
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->pro_pic = $img_name;
        $user->save();
        return $this->me($request);
    }

}
