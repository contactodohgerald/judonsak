<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recievable extends Model
{
	public function feenote()
	{
		return $this->belongsTo(Feenote::class);
	}

	public function currency()
	{
		return $this->belongsTo(Currency::class);
	}
}
