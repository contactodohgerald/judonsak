<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Events\InstructionDeleted;
use App\Events\InstructionRetrieved;
use Illuminate\Support\Facades\Auth;

class Instruction extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $dispatchesEvents = [
        'deleted' => InstructionDeleted::class,
        'retrieved' => InstructionRetrieved::class,
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
	public function frequencies()
	{
		return $this->belongsTo(Frequency::class);
	}

    public function contract()
    {
        return $this->belongsTo('App\Models\Contract');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function people()
    {
        return $this->belongsToMany(Person::class);
    }

    public function person()
    {
        return $this->belongsToMany(Person::class);
    }

    public function myInstructions()
    {
        return $this->people()->wherePivot('person_id', Auth::id() );
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
