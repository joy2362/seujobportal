<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class shortListEvent extends Model
{
    protected $fillable = [
        'email', 'eventId'
    ];
}
