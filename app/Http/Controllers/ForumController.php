<?php

namespace App\Http\Controllers;

use App\Comments;
use App\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($email)
    {
        $forum=Forum::where('email','!=' ,$email)->orderBy('id', 'desc')->take(10)
            ->get();
        return response()->json(['otherPost'=>$forum]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $forum=Forum::where('id',$id)->first();
        return response()->json(['post'=>$forum]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $post=Forum::where('id',$id)->first();
        if($request->image){
            if($post->image){
                unlink($post->image);
            }

            $ext = $request->file('image')->extension();
            $name=Str::random(10).".".$ext;
            $img=Image::make($request->image)->resize(250,250);
            $upload='asset/img/forum';
            $img_name=$upload.'/'.$name;
            $img->save($img_name);
            $post->image=$img_name;
        }
        $post->title=$request->title;
        $post->description=$request->detail;
        $post->save();
        return response()->json(['msg'=>"your Post Updated Successfully"]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Forum::destroy($id);
        Comments::where('post_id',$id)->delete();
        return response()->json(['msg'=>'Post deleted successfully '],200);
    }
    /**
     * return specific user post
     *
     * @param   $email
     * @return \Illuminate\Http\JsonResponse
     */
    public function myPost($email){
        $forum=Forum::where('email',$email)->get();
        return response()->json(['myPost'=>$forum]);
    }

    public function newComment(Request $request){
        $comment=new Comments();
        $comment->email=$request->email;
        $comment->post_id=$request->post_id;
        $comment->comment=$request->comment;
        $comment->save();
        return response()->json(['msg'=>'success']);
    }

    public function allComment($id){
        $comment=Comments::where('post_id',$id)
            ->orderBy('id', 'desc')
            ->take(15)
            ->get();
        return response()->json(['comments'=>$comment]);
    }
    public function destroyComment($id){
        Comments::destroy($id);
        return response()->json(['msg'=>'comment Removed']);
    }
    public function updateComment($id,Request $request){
        Comments::where('id',$id)->update(['comment'=>$request->comment]);
        return response()->json(['msg'=>'comment updated'],200);
    }
}
