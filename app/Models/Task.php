<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Events\TaskDeleted;
use App\Events\TaskCreated;

class Task extends Model
{
    use Sluggable;
    use SoftDeletes;

    public $table = 'tasks';

    protected $dates = ['deleted_at'];

    protected $dispatchesEvents = [
        'deleted' => TaskDeleted::class,
        'created' => TaskCreated::class
    ];


    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
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

    public function executor()
    {
        return $this->belongsTo(Person::class);
    }

    public function line_manager()
    {
        return $this->belongsTo(Person::class);
    }

    public function taskPoint()
    {
        return $this->hasOne(TaskPoint::class);
    }
}
