<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class interestSectionAlumni extends Model
{
    protected $fillable = [
        'section', 'user_id',
    ];
    public function alumni()
    {
        return $this->belongsTo('App\Alumni');
    }
}
