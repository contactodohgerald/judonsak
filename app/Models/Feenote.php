<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feenote extends Model
{
	public function payment()
	{
		return $this->belongsTo(Payment::class);
	}

	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function recievables()
	{
		return $this->hasMany(Recievable::class);
	}
}
