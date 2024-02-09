<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Person;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\{Type, Level};

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;


    protected $fillable = [
        'name', 'email', 'password', 'profile_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function person()
    {
        return $this->hasOne(Person::class);
    }

    public function getImageAttribute()
    {
        return $this->profile_image;
    }

    // public function people()
    // {

    // }


}
