<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class JobPost extends Model
{
    use Notifiable;
    protected $fillable = [
        'email', 'phone','name','JobType','location','company','address'
        ,'experience','category','salary','jobDetails','requerments',
        'qualification','benefit','lastdate','dutyStart','dutyEnd','vacency','verify','owner'
    ];

}
