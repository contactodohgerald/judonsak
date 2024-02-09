<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskPoint extends Model
{
    public function task()
    {
        return $this->hasOne(Task::class);
    }

    public function person() {
        return $this->belongsTo(Person::class);
    }
}
