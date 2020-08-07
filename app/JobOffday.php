<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOffday extends Model
{
    protected $fillable = [
        'job_id', 'day'
    ];
}
