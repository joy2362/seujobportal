<?php

namespace App\Http\Controllers\Admin\job;

use App\Http\Controllers\Controller;
use App\Category;
use App\JobOffday;
use App\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;
use DB;

class Jobcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(JobPost::all());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $number=count($request->offday);

        $job= new JobPost();
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
        $job->verify=1;
        $job->save();
        for ($i=0;$i<$number;$i++){
            $offday=new JobOffday();
            $offday->job_id=$job->id;
            $offday->day=$request->offday[$i];
            $offday->save();
        }
        $category=Category::where('id',$request->category)->first();
        $category->total_job += $request->vacency;
        $category->save();
        return response()->json(['msg'=>'Job Post Added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $jobs = DB::table('job_posts')
            ->join('categories', 'job_posts.category', '=', 'categories.id')
            ->select('job_posts.*', 'categories.name as category_name')
            ->where('job_posts.id',$id)
            ->get();
        $offday=JobOffday::where('job_id',$id)->get();
        return response()->json([$jobs,$offday]);
    }
    /**
     * fatch the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function fatch($id)
    {
        $job=JobPost::where('id',$id)->first();
        $offday=JobOffday::where('job_id',$id)->get();
        return response()->json([$job,$offday]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request ,$id)
    {
        $job=JobPost::where('id',$id)->first();

        $category=Category::where('id',$job->category)->first();
        $category->total_job -=  $job->vacency;
        $category->save();

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
        $job->verify=1;
        $job->save();
        $number=count($request->offday);
        JobOffday::where('job_id',$job->id)->delete();
         for ($i=0;$i<$number;$i++){
            $offday=new JobOffday();
            $offday->job_id=$job->id;
            $offday->day=$request->offday[$i];
            $offday->save();
        }
        $category=Category::where('id',$request->category)->first();
        $category->total_job += $request->vacency;
        $category->save();

        return response()->json(['msg'=>'Job Post Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job=JobPost::where('id',$id)->first();
        $category=Category::where('id',$job->category)->first();
        $category->total_job -= $job->vacency;
        $category->save();
        JobPost::where('id',$id)->delete();
        JobOffday::where('job_id',$id)->delete();
        return response()->json(['msg'=>'Job Post Delete Successfully']);
    }
}
