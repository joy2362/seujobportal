<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feadback extends Model
{
    protected $fillable = [
        'review', 'email'
    ];
}
