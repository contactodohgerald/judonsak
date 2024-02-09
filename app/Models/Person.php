<?php

namespace App\Models;

use App\{Country, State};
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Person extends Model
{
    use Notifiable;
    use Sluggable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'first_name'
            ]
        ];
    }

    public function countries()
    {
        return $this->belongsTo(Country::class);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function states()
    {
        return $this->belongsTo(Country::class);
    }

    public function level()
    {
        return $this->belongsTo('App\Level');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // public function organisations()
    // {
    //  return $this->belongsToMany(Organisations::class);
    // }

    public function logs()
    {
        return $this->hasmany(Log::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function task()
    {
        return $this->hasOne(Task::class);
    }

    public function supervisedTask()
    {
        return $this->hasOne(Task::class);
    }

    public function generalPoint()
    {
        return $this->hasMany(GeneralPoint::class);
    }

    public function taskPoint() {
        return $this->hasMany(TaskPoint::class);
    }
}
