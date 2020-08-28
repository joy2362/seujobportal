<?php

namespace App\Http\Controllers;

use App\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'detail' => 'required',
            'email' => 'required',
            'image'=> ' image'
        ]);
        $forum=new Forum();
        if($request->image){
            $ext = $request->file('image')->extension();
            $name=Str::random(10).".".$ext;
            $img=Image::make($request->image)->resize(250,250);
            $upload='asset/img/forum';
            $img_name=$upload.'/'.$name;
            $img->save($img_name);
            $forum->image=$img_name;
        }
        $forum->title=$request->title;
        $forum->description=$request->detail;
        $forum->email=$request->email;
        $forum->save();
        return response()->json(['msg'=>"your Post added Successfully"]);

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
        //
    }

    public function myPost($email){
        $forum=Forum::where('email',$email)->get();
        return response()->json(['myPost'=>$forum]);
    }
}
