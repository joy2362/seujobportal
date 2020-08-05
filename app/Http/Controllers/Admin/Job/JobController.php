<?php

namespace App\Http\Controllers\Admin\Job;

use App\Category;
use App\Http\Controllers\Controller;
use App\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

class JobController extends Controller
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

        $img = $request->file('image');
        $ext = $request->file('image')->extension();
        $name=Str::random(10).".".$ext;
        $upload='asset/img/job';
        $img_name=$upload.'/'.$name;
        Image::make($request->image)->resize(250,250);
        $img->move($upload,$name);

        $job= new JobPost();
        $job->title=$request->title;
        $job->JobType=$request->JobType;
        $job->location=$request->location;
        $job->company=$request->company;
        $job->address=$request->address;
        $job->experience=$request->experience;
        $job->category=$request->category;
        $job->offday=$request->offday;
        $job->salary=$request->salary;
        $job->jobDetails=$request->jobDetails;
        $job->requerments=$request->requerments;
        $job->qualification=$request->qualification;
        $job->image= $img_name;
        $job->benefit=$request->benefit;
        $job->lastdate=$request->lastdate;
        $job->dutyStart=$request->dutyStart;
        $job->dutyEnd=$request->dutyEnd;
        $job->vacency=$request->vacency;
        $job->save();
        $category=Category::where('id',$request->category)->first();
        $category->total_job += $request->vacency;
        $category->save();
       return response()->json(['msg'=>'Job Post Added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        unlink($job->image);
        JobPost::where('id',$id)->delete();
        return response()->json(['msg'=>'Job Post Delete Successfully']);
    }
}
