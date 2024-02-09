<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    public function instructions()
    {
        return $this->hasMany(Instruction::class);
	}
	
    public function contracts()
    {
        return $this->belongsToMany(Contract::class);
    }

    public function tasks()
    {
        return $this->hasManyThrough(Task::class, Instruction::class);
    }

}
