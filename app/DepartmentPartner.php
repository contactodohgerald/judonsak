<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentPartner extends Model
{
    public function department()
    {
        return $this->hasMany(Person::class);
    }

    public function person()
    {
        return $this->belongsTo(Department::class);
    }
}
