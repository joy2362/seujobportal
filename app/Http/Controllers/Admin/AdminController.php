<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Alumnni;
use App\Event;
use App\Faculty;
use App\Http\Controllers\Controller;
use App\JobPost;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    public function adminreg(Request $request){
        if($this->EmailCheck($request->email)){
            return response()->json(['message' => 'Email already taken'] ,404);
        }

        $name=Str::random(10).".png";
        $upload='asset/img/admin';
        $img_name=$upload.'/'.$name;

        (new \Laravolt\Avatar\Avatar)->create($request->name)->setFontSize(72)->setDimension(250, 250)->save($img_name);

        $user=new Admin();
        $user->name =$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->verify=Hash::make($request->verification);
        $user->pro_pic = $img_name;
        $user->email_verified_at =now();
        $user->save();
        return response()->json(['message'=>'New Admin Added !!']);
    }

    public function allAdmin(){
        $admin=Admin::where('id','!=',1)->get();
        return response()->json($admin);
    }

    public function destroy($id){
        $admin=Admin::where('id',$id)->first();
        unlink($admin->pro_pic);
        Admin::destroy($id);
        return response()->json(['msg'=>'Admin Deleted !!']);
    }

    protected  function countUser(){
        $totalUser=0;
        $alumni=Alumnni::all();
        $faculty=Faculty::all();
        $student=User::all();
        $totalUser+=$alumni->count();
        $totalUser+=$faculty->count();
        $totalUser+=$student->count();
        return $totalUser;
    }
    public function adminHome(){
      $user=$this->countUser();
      $Job=JobPost::all();
      $totalJob=$Job->count();

      $student=User::where('active',0)->get();
      $faculty=Faculty::where('active',0)->get();
      $alumni=Alumnni::where('active',0)->get();

      $event= Event::where('eventDate','<',now())->get();
      $job= JobPost::where('lastdate','<',now())->get();
      $Events=Event::all();
      $totalEvents=$Events->count();

      return response()->json(['totaluser'=>$user,
          'totalJob'=>$totalJob,
          'student'=>$student,
          'faculty'=>$faculty,
          'alumni'=>$alumni,
          'event'=>$event,
          'job'=>$job,
          'totalEvents'=>$totalEvents
      ]);
    }

    public function studentDestroy($id){
        $student=User::where('id',$id)->first();
        unlink($student->pro_pic);
        unlink($student->cv);
        User::destroy($id);
        return response()->json(['msg'=>'Student Account Deleted']);
    }

    public function alumniDestroy($id){
        $student=Alumnni::where('id',$id)->first();
        unlink($student->pro_pic);
        unlink($student->cv);
        Alumnni::destroy($id);
        return response()->json(['msg'=>'Alumni Account Deleted']);
    }

    public function facultyDestroy($id){
        $faculty=Faculty::where('id',$id)->first();
        unlink($faculty->pro_pic);
        Faculty::destroy($id);
        return response()->json(['msg'=>'Faculty Account Deleted']);
    }
}
