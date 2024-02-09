<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = [
        'name', 
        'date', 
        'contact_id'
    ];

    public function Contact()
    {
    	return $this->belongsTo(Contact::class);
    }
}
