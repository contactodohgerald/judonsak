<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Budget extends Model
{
    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

	public function getRouteKeyName()
	{
		return 'slug';
	}

    public function expenditures()
    {
        return $this->hasMany(Expenditure::class);
    }
    
    public function revenues()
    {
        return $this->hasMany(Revenue::class);
    }
    
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    
    public function logs()
    {
        return $this->morphMany('App\Models\Log', 'logable');
    }	

}
