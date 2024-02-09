<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\ContractDeleted;

class Contract extends Model
{
    use Sluggable;
    use SoftDeletes;


    protected $dates = ['deleted_at'];

    protected $dispatchesEvents = [
        'deleted' => ContractDeleted::class,
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

	public function client()
	{
		return $this->belongsTo(Client::class)->orderBy('name');
	}
	
	public function currency()
	{
		return $this->belongsTo(Currency::class);
	}
	
	public function services()
	{
		return $this->belongsToMany(Service::class);
	}
	
	public function status()
	{
		return $this->belongsTo(Status::class);
	}
	
	public function payments()
	{
		return $this->hasMany(Payment::class);
	}

	public function instructions()
	{
		return $this->hasMany(Instruction::class);
	}

	public function addPayments($body)
	{
		$this->payments()->createMany($body);
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
