<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Alumnni;
use App\AppliedJob;
use App\Category;
use App\Faculty;
use App\Feadback;
use App\JobOffday;
use App\Mail\ApplyJob;
use App\Mail\facultyApplyJob;
use App\User;
use DB;
use App\Event;
use App\JobPost;
use App\shortList;
use App\shortListEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        $category = Category::where('id',$job->category)->first();

        return response()->json(['job'=> $job,'user'=>$user,'offday'=>$offday ,'category'=> $category]);
    }

    public function addFeadback(Request $request){
        $feadback = new Feadback();
        $feadback->email = $request->email;
        $feadback->review = $request->review;
        $feadback->save();

        return response()->json(['msg'=>'Thank you for your message']);

    }

    public function allcategory(){
        $category = Category::orderBy('total_job', 'desc')->paginate(20);
        return response()->json([ 'category'=> $category ]);
    }

    public function alljob(){
        $job = JobPost::where('verify','1')
            ->where('lastdate','>',now())
            ->orderBy('vacency', 'desc')
            ->paginate(10);

        return response()->json([ 'job'=>  $job ]);
    }

    public function jobFilter(Request  $request){
        $exprienceStart=$request->experience[0];
        $exprienceEnd=$request->experience[1];

        $salaryStart=$request->salary[0];
        $salaryEnd=$request->salary[1];

        if ($request->category && $request->location !="3"){
            $job=JobPost::where('verify','1')
                ->where('lastdate','>',now())
                ->where('category',$request->category)
                ->where('location',$request->location)
                ->whereBetween('experience', [$exprienceStart, $exprienceEnd])
                ->whereBetween('salary', [$salaryStart, $salaryEnd])
                ->paginate(1);
            return response()->json([ 'job'=> $job ]);
        }elseif (!$request->category && $request->location !="3"){
            $job=JobPost::where('verify','1')
                ->where('lastdate','>',now())
                ->where('location',$request->location)
                ->whereBetween('experience', [$exprienceStart, $exprienceEnd])
                ->whereBetween('salary', [$salaryStart, $salaryEnd])
                ->paginate(1);
            return response()->json([ 'job'=> $job ]);
        }elseif($request->location =="3" && $request->category){
            $job=JobPost::where('verify','1')
                ->where('lastdate','>',now())
                ->where('category',$request->category)
                ->whereBetween('experience', [$exprienceStart, $exprienceEnd])
                ->whereBetween('salary', [$salaryStart, $salaryEnd])
                ->paginate(1);
            return response()->json([ 'job'=> $job ]);
        }else{
            $job=JobPost::where('verify','1')
                ->where('lastdate','>',now())
                ->whereBetween('experience', [$exprienceStart, $exprienceEnd])
                ->whereBetween('salary', [$salaryStart, $salaryEnd])
                ->paginate(1);
            return response()->json([ 'job'=> $job ]);
        }

    }
    public function alljobCategory($id){
        $job = JobPost::where('verify','1')
            ->where('lastdate','>',now())
            ->where('category',$id)
            ->orderBy('vacency', 'desc')
            ->paginate(10);
        return response()->json([ 'job'=>  $job ]);
    }

    public function searchJob(Request $request){
        if ($request->location === '3'){
            $job = JobPost::where('verify','1')
                ->where('lastdate','>',now())
                ->where('name' ,'like', '%' .$request->title . '%')
                ->orderBy('vacency', 'desc')
                ->paginate(10);
        }else{
            $job = JobPost::where('verify','1')
                ->where('lastdate','>',now())
                ->where('location',$request->location)
                ->where('name' ,'like', '%' .$request->title . '%')
                ->orderBy('vacency', 'desc')
                ->paginate(10);
        }

        return response()->json([ 'job'=>  $job ]);
    }


    public function applyJob(Request $request){
        $applyJob=AppliedJob::where('email',$request->email)
            ->where('jobId',$request->id)->first();
        if($applyJob){
            return response()->json(['msg'=>'Already Added'],404);
        }
        $user=$this->UserSelect($request->email);
        $job = JobPost::where('id',$request->id)->first();

        mail::to($job->email)->send(new ApplyJob($job,$user));

        $jobPost=new AppliedJob();
        $jobPost->email=$request->email;
        $jobPost->jobId=$request->id;
        $jobPost->save();

        return response()->json(['msg'=>'Apply for the post complete.']);

    }
    public function facultyApplyJob(Request $request){
        $applyJob=AppliedJob::where('email',$request->email)
            ->where('jobId',$request->id)->first();
        if($applyJob){
            return response()->json(['msg'=>'Already Added'],404);
        }
        $user=$this->UserSelect($request->email);
        $job = JobPost::where('id',$request->id)->first();
        mail::to($job->email)->send(new facultyApplyJob($job,$user,$request->cv));

        $jobPost=new AppliedJob();
        $jobPost->email=$request->email;
        $jobPost->jobId=$request->id;
        $jobPost->save();
        return response()->json(['msg'=>'Apply for the post complete.']);
    }

}
