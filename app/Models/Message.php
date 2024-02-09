<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['message'];

    public function conversation()
	    {
	    	return $this->belongsTo(Conversation::class);
	    }

    public function person()
	    {
	    	return $this->belongsTo(Person::class);
	    }    
}
