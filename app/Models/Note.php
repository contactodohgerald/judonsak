<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function logs()
    {
        return $this->morphMany('App\Models\Log', 'logable');
    }

}
