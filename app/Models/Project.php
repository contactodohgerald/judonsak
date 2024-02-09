<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Project extends Model
{
    protected $dates = ['deleted_at'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function checklist()
    {
        return $this->hasMany(Checklist::class);
    }

    public function people()
    {
        return $this->belongsToMany(Person::class);
    }

    public function logs()
    {
        return $this->morphMany('App\Models\Log', 'logable');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
