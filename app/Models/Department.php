<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    public function people()
    {
        return $this->hasMany(Person::class);
    }

    public function partner() {
        return $this->hasMany(Person::class);
    }

}
