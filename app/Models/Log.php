<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public function logable()
    {
        return $this->morphTo();
    }

    public function person()
    {
    	return $this->belongsTo('App\Models\Person');
    }
}
