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
        if ($faculty){
            return ($faculty);
        }
        if ($alumni){
            return ($alumni);
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
}
