<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Alumnni;
use App\Faculty;
use App\Feadback;
use App\JobOffday;
use App\User;
use DB;
use App\Event;
use App\JobPost;
use App\shortList;
use App\shortListEvent;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $recentJob=JobPost::where('verify','1')
            ->where('lastdate','>',now())
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        $featuredJob=JobPost::where('verify','1')
            ->where('lastdate','>',now())
            ->orderBy('vacency', 'desc')
            ->take(10)
            ->get();

        $events=Event::where('verify','1')
            ->where('eventDate','>',now())
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        return response()->json([
            'recentJob'=> $recentJob,
            'featuredJob'=> $featuredJob,
            'event'=> $events,
        ]);
    }

    public function addShortList(Request $request){
        $shortlisted = shortList::where('email',$request->email)
            ->where('jobId',$request->jobId)
            ->first();

        if($shortlisted){
            return response()->json(['msg'=>'Already Added'],404);
        }else{
            $shortlist = new shortList();
            $shortlist->email = $request->email;
            $shortlist->jobId = $request->jobId;
            $shortlist->save();

            return response()->json(['msg'=>'ok']);
        }
    }

    public function addShortListEvent(Request $request){
        $shortlisted = shortListEvent::where('email',$request->email)
            ->where('eventId',$request->eventId)
            ->first();
        if($shortlisted){
            return response()->json(['msg'=>'Already Added'],404);
        }else{
            $shortlist = new shortListEvent();
            $shortlist->email = $request->email;
            $shortlist->eventId = $request->eventId;
            $shortlist->save();

            return response()->json(['msg'=>'ok']);
        }
    }

    public function allevent(){
        $events=Event::where('verify','1')
            ->where('eventDate','>',now())
            ->paginate(10);

        return response()->json(['event'=> $events]);
    }

    private function UserSelect($email){
        $faculty=Faculty::where('email',$email)->first();
        $alumni=Alumnni::where('email',$email)->first();
        $user=User::where('email',$email)->first();
        $admin=Admin::where('email',$email)->first();
        if ($faculty){
            return ($faculty);
        }if ($alumni){
            return ($alumni);
        }if ($admin){
            return ($admin);
        }if ($user){
            return ($user);
        }
    }

    public function singleevent($id){
        $events=Event::where('verify','1')
            ->where('id',$id)
            ->first();
        $user=$this->UserSelect($events->owner);

        return response()->json(['event'=> $events,'user'=>$user]);
    }

    public function singlejob($id){
        $job=JobPost::where('verify','1')
            ->where('id',$id)
            ->first();
        $user=$this->UserSelect($job->owner);
        $offday = JobOffday::where('job_id',$id)
            ->first();

        return response()->json(['job'=> $job,'user'=>$user,'offday'=>$offday]);
    }

    public function addFeadback(Request $request){
        $feadback = new Feadback();
        $feadback->email = $request->email;
        $feadback->review = $request->review;
        $feadback->save();

        return response()->json(['msg'=>'Thank you for your message']);

    }
}
