<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Cviebrock\EloquentSluggable\Sluggable;
// use Illuminate\Support\Str;

// return (string) Str::uuid();
class Conversation extends Model
{
    // use Sluggable;
    use SoftDeletes;

    public function messages()
    {
    	return $this->hasMany(Message::class);
    }

    public function people()
    {
    	return $this->belongsToMany(Person::class)->withPivot('other_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
    // public function otherPerson()
    // {
    //     return $this->people();
    // }
}
