<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Events\ClientDeleted;

class Client extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $dispatchesEvents = [
        'deleted' => ClientDeleted::class,
    ];

    protected $dates = ['deleted_at'];
    protected $fillable = [
        "state_id",
        "address",
        "phone_num",
        "email",
        "tin",
        "industry",
        "nature_of_business",
        "name" 
    ];


    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function descContracts()
    {
        return $this->hasMany(Contract::class)->orderBy('name', 'asc');
    }

    public function instructions()
    {
        return $this->hasManyThrough(Instruction::class, Contract::class);
    }

    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Payment::class);
    }

    public function addContacts($body)
    {
        $this->contacts()->createMany([$body]);
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
