<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'company' ,'location', 'address', 'eventDate', 'eventStart' ,'details',
    ];
}
