<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Alumnni;
use App\Event;
use App\Faculty;
use App\JobOffday;
use App\JobPost;
use App\Notifications\eventPending;
use App\Notifications\jobpending;
use App\shortList;
use App\shortListEvent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Image;
use DB;

class UserDetails extends Controller
{
    public function profile($email){
        $faculty=Faculty::where('email',$email)->first();
        $student=User::where('email',$email)->first();
        $alumni=Alumnni::where('email',$email)->first();

        if ($faculty){
            $verify=\Carbon\Carbon::parse($faculty->email_verified_at)->diffForHumans();
            $create=\Carbon\Carbon::parse($faculty->created_at)->diffForHumans();
            return response()->json(['user'=>$faculty,'verify'=>$verify,'create'=>$create]);
        }elseif ($alumni){
            $verify=\Carbon\Carbon::parse($alumni->email_verified_at)->diffForHumans();
            $create=\Carbon\Carbon::parse($alumni->created_at)->diffForHumans();
            return response()->json(['user'=>$alumni,'verify'=>$verify,'create'=>$create]);
        }elseif ($student){
            $verify=\Carbon\Carbon::parse($student->email_verified_at)->diffForHumans();
            $create=\Carbon\Carbon::parse($student->created_at)->diffForHumans();
            return response()->json(['user'=>$student,'verify'=>$verify,'create'=>$create]);
        }
    }

    public function addJob(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|unique:job_posts',
            'jobDetails' => 'required|min:10',
            'requerments' => 'required|min:10',
            'benefit' => 'required|min:10',
            'qualification' => 'required|min:10',
            'phone' => 'required||regex:/(01)[0-9]{9}/',
        ]);

        $number=count($request->offday);
        $job= new JobPost();
        $job->email=$request->email;
        $job->phone=$request->phone;
        $job->name=$request->name;
        $job->JobType=$request->JobType;
        $job->location=$request->location;
        $job->company=$request->company;
        $job->address=$request->address;
        $job->experience=$request->experience;
        $job->category=$request->category;
        $job->salary=$request->salary;
        $job->jobDetails=$request->jobDetails;
        $job->requerments=$request->requerments;
        $job->qualification=$request->qualification;
        $job->benefit=$request->benefit;
        $job->lastdate=$request->lastdate;
        $job->dutyStart=$request->dutyStart;
        $job->dutyEnd=$request->dutyEnd;
        $job->vacency=$request->vacency;
        $job->owner=$request->owner;

        $job->save();

        for ($i=0;$i<$number;$i++){
            $offday=new JobOffday();
            $offday->job_id=$job->id;
            $offday->day=$request->offday[$i];
            $offday->save();
        }
        $user=$this->UserSelect($job->owner);
        $user->notify(
            new jobpending()
        );

        return response()->json(['msg'=>'Job Post Added for Admin verification']);
    }

    private function UserSelect($email){
        $faculty=Faculty::where('email',$email)->first();
        $alumni=Alumnni::where('email',$email)->first();
        $student=User::where('email',$email)->first();

        if ($faculty){
            return ($faculty);
        }
        if ($alumni){
            return ($alumni);
        }
        if ($student){
            return ($student);
        }
    }

    public function addevent(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|unique:events',
            'details' => 'required|min:10',
        ]);

        $event=new Event();
        $event->name=$request->name;
        $event->company=$request->company;
        $event->location=$request->location;
        $event->address=$request->address;
        $event->eventDate=$request->eventDate;
        $event->eventStart=$request->eventStart;
        $event->details=$request->details;
        $event->owner=$request->owner;
        $event->save();

        $user=$this->UserSelect($event->owner);
        $user->notify(
            new eventPending()
        );
        return response()->json(['msg'=>"Event post is pending"]);
    }


    public function imageChange($email , Request $request){
        $user=$this->UserSelect($email);;
        unlink($user->pro_pic);

        $ext = $request->file('image')->extension();
        $name=Str::random(10).".".$ext;
        $img=Image::make($request->image)->resize(250,250);
        $upload='asset/img/admin';
        $img_name=$upload.'/'.$name;
        $img->save($img_name);

        $user->pro_pic=$img_name;
        $user->save();

        return response()->json(['msg'=>'Image Updated successfully !!']);
    }

    public function namechange($email,Request $request){
        $user=$this->UserSelect($email);;
        $user->name=$request->name;
        $user->save();
        return response()->json(['msg'=>'Name Changed !!']);
    }

    public function passwordchange($email,Request $request){
        $user=$this->UserSelect($email);
        if (! Hash::check($request->oldpassword,$user->password)){
            return response()->json(['msg'=>'Current Password not matched !!'],404);
        }
        $user->password=Hash::make($request->newpassword);
        $user->save();

        return response()->json(['msg'=>'Password Changed !!']);
    }

    public function cvchange($email , Request $request){
        $validatedData = $request->validate([
            'cv' => 'required|mimetypes:application/pdf',
        ]);
        $cv = $request->file('cv');
        $cvext=$request->file('cv')->extension();
        $cvname=Str::random(10).".".$cvext;
        $destinationPath="asset/cv/alumni";
        $cv->move($destinationPath,$cvname);
        $cvsource=$destinationPath."/".$cvname;

        $user=$this->UserSelect($email);
        unlink($user->cv);
        $user->cv =  $cvsource;
        $user->save();

        return response()->json(['msg'=>'Cv Updated !!']);

    }

    public function eventFavouriteList($email){
        $event = DB::table('short_list_events')
            ->join('events', 'events.id', '=', 'short_list_events.eventId')
            ->select('short_list_events.*', 'events.name')
            ->paginate(10);

        return response()->json([ 'event'=>$event ]);
    }

    public function jobFavouriteList($email){
        $job = DB::table('short_lists')
            ->join('job_posts', 'job_posts.id', '=', 'short_lists.jobId')
            ->select('short_lists.*', 'job_posts.name')
            ->paginate(10);

        return response()->json([ 'job'=>$job ]);
    }

    public function removeJob($id){
        shortList::destroy($id);
        return response()->json(['msg'=>'Removed From Favourite List !!']);
    }

    public function removeEvent($id){
        shortListEvent::destroy($id);
        return response()->json(['msg'=>'Removed From Favourite List !!']);
    }

}
