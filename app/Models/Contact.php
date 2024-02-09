<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $fillable = [ 
    	'name', 
    	'client_id', 
    	'designation', 
        'phone_num',
        'birthday',
    	'anniversary',
    	'email'
    ];

	public function clients()
	{
		return $this->belongsTo(Client::class);
	}

    public function Calendar()
    {
    	return $this->hasMany(Contact::class);
    }
}
