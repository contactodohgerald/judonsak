<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
	// this model shows which type of user e.g corperate client admin.
	public function users()
	{
		return $this->hasMany(User::class);
	}
}
