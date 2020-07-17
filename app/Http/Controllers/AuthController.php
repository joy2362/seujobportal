<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Alumnni;
use App\Faculty;
use App\interestSectionAlumni;
use App\interestSectionStudent;
use App\User;
use http\Env\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected function EmailCheck($email){
        $faculty=Faculty::where('email',$email)->first();
        $student=User::where('email',$email)->first();
        $admin=Admin::where('email',$email)->first();
        $alumni=Alumnni::where('email',$email)->first();

        if($student || $admin || $faculty || $alumni){
            return true;
        }else{
            return false;
        }
    }
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
            'name' => auth('faculty')->user()->name,
            'email' => auth('faculty')->user()->email,
            'permission' => auth('faculty')->user()->user_type,
            'profile_pic' => auth('faculty')->user()->pro_pic,
            'expires_in' =>  auth('faculty')->factory()->getTTL() * 60
        ]);
    }
    protected function studentrespondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'name' => auth('api')->user()->name,
            'email' => auth('api')->user()->email,
            'permission' => auth('api')->user()->user_type,
            'profile_pic' => auth('api')->user()->pro_pic,
            'expires_in' =>  auth('api')->factory()->getTTL() * 60
        ]);
    }
    protected function adminrespondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'name' => auth('admin')->user()->name,
            'email' => auth('admin')->user()->email,
            'permission' => auth('admin')->user()->user_type,
            'profile_pic' => auth('admin')->user()->pro_pic,
            'expires_in' =>  auth('admin')->factory()->getTTL() * 60
        ]);
    }
    protected function alumnirespondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'name' => auth('alumni')->user()->name,
            'email' => auth('alumni')->user()->email,
            'permission' => auth('alumni')->user()->user_type,
            'profile_pic' => auth('alumni')->user()->pro_pic,
            'expires_in' =>  auth('alumni')->factory()->getTTL() * 60
        ]);
    }

    public function teacherreg(Request $request){

        if($this->EmailCheck($request->email)){
            return response()->json(['message' => 'Email already taken'] ,404);
        }

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
        return response()->json(['message'=>'Registation Complete']);
    }

    public function alumnireg(Request $request){

        if($this->EmailCheck($request->email)){
            return response()->json(['message' => 'Email already taken'] ,404);
        }

        $number=count($request->interestfield);

        $ext = $request->file('image')->extension();
        $name=Str::random(10).".".$ext;
        $img=Image::make($request->image)->resize(250,250);
        $upload='asset/img/alumni';
        $img_name=$upload.'/'.$name;
        $img->save($img_name);

        $cv = $request->file('cv');
        $cvext=$request->file('cv')->extension();
        $cvname=Str::random(10).".".$cvext;
        $destinationPath="asset/cv/alumni";
        $cv->move($destinationPath,$cvname);
        $cvsource=$destinationPath."/".$cvname;

        $user=new Alumnni;
        $user->name =$request->name;
        $user->user_type = "3";
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->pro_pic = $img_name;
        $user->cv =  $cvsource;
        $user->save();
        $userid=$user->id;


        for ($i=0; $i <$number ; $i++) {
            $section=new interestSectionAlumni;
            $section->user_id=$userid;
            $section->section=$request->interestfield[$i];
            $section->save();
        }
        return response()->json(['message'=>'Registation Complete']);
    }

    public function studentreg(Request $request){
        if($this->EmailCheck($request->email)){
            return response()->json(['message' => 'Email already taken'] ,404);
        }
        $number=count($request->interestfield);
        $ext = $request->file('image')->extension();
        $name=Str::random(10).".".$ext;
        $img=Image::make($request->image)->resize(250,250);
        $upload='asset/img/student';
        $img_name=$upload.'/'.$name;
        $img->save($img_name);

        $cv = $request->file('cv');
        $cvext=$request->file('cv')->extension();
        $cvname=Str::random(10).".".$cvext;
        $destinationPath="asset/cv/student";
        $cv->move($destinationPath,$cvname);
        $cvsource=$destinationPath."/".$cvname;

        $user = User::create([
            'name' => $request->name,
            'user_type' => '4',
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'pro_pic' => $img_name,
            'cv' => $cvsource,
        ]);
        $userid=$user->id;

        for ($i=0; $i <$number ; $i++) {
            $section=new interestSectionStudent;
            $section->user_id=$userid;
            $section->section=$request->interestfield[$i];
            $section->save();
        }

        return response()->json(['message'=>'Registation Complete']);
    }


}
