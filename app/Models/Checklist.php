<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Checklist extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
 
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function logs()
    {
        return $this->morphMany('App\Models\Log', 'logable');
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function people()
    {
        return $this->belongsToMany(Person::class);
    }

}
