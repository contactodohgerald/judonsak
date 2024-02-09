<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Person, Client};
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function clients()
    {
     $this->belongsTo(Clients::class);
    }

}
