<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    protected $fillable = [
        'email', 'phone','name','JobType','location','company','address'
        ,'experience','category','salary','jobDetails','requerments',
        'qualification','benefit','lastdate','dutyStart','dutyEnd','vacency','verify'
    ];

}
