<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
	public function cashbooks()
	{
		return $this->hasMany(Cashbook::class);
	}
	public function currency()
	{
		return $this->belongsTo(Currency::class);
	}
}
