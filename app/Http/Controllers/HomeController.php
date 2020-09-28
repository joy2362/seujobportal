<?php

namespace App\Http\Controllers;

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

    public function singleevent($id){
        $events=Event::where('verify','1')
            ->where('id',$id)
            ->first();
        return response()->json(['event'=> $events]);
    }
}
