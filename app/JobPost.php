<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    protected $fillable = [
        'title','JobType','location','company','address'
        ,'experience','category','offday','salary','jobDetails','requerments',
        'qualification','image','benefit','lastdate','dutyStart','dutyEnd','vacency'
    ];
}
