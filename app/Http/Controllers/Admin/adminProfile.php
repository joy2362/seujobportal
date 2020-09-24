<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class adminProfile extends Controller
{
    public function info($id){
        $admin=Admin::where('id',$id)->first();
        $verify=\Carbon\Carbon::parse($admin->email_verified_at)->diffForHumans();
        $create=\Carbon\Carbon::parse($admin->created_at)->diffForHumans();
        return response()->json(['user'=>$admin,'verify'=>$verify,'create'=>$create]);
    }

    public function imageChange($id,Request $request){
        $admin=Admin::where('id',$id)->first();
        unlink($admin->pro_pic);

        $ext = $request->file('image')->extension();
        $name=Str::random(10).".".$ext;
        $img=Image::make($request->image)->resize(250,250);
        $upload='asset/img/admin';
        $img_name=$upload.'/'.$name;
        $img->save($img_name);

        Admin::where('id',$id)->update(['pro_pic'=>$img_name]);

        return response()->json(['msg'=>'Image Updated successfully !!']);

    }

    public function namechange($id,Request $request){
        Admin::where('id',$id)->update(['name'=>$request->name]);
        return response()->json(['msg'=>'Name Changed !!']);
    }

    public function passwordchange($id,Request $request){
        $admin=Admin::where('id',$id)->first();
        if (! Hash::check($request->oldpassword,$admin->password)){
            return response()->json(['msg'=>'Current Password not matched !!'],404);
        }
        Admin::where('id',$id)->update(['password'=>Hash::make($request->newpassword)]);
        return response()->json(['msg'=>'Password Changed !!']);
    }

    public function validationchange($id,Request $request){
        $admin=Admin::where('id',$id)->first();
        if (! Hash::check($request->oldvalidation,$admin->verify)){
            return response()->json(['msg'=>'Current Validation Code not matched !!'],404);
        }
        Admin::where('id',$id)->update(['verify'=>Hash::make($request->newvalidation)]);
        return response()->json(['msg'=>'Validation Code Changed !!']);
    }

}
