<?php

namespace App\Http\Controllers;

use App\JobPost;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $recentJob=JobPost::where('verify','1')->where('lastdate','>',now())->take(10)->get();
        return response()->json(['recentJob'=> $recentJob,
        ]);
    }
}
