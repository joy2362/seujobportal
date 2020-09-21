<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class shortList extends Model
{
    protected $fillable = [
        'email', 'jobId'
    ];
}
