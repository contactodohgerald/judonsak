<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralPoint extends Model
{
    public function person()
    {
        return $this->hasOne(Person::class);
    }
}
