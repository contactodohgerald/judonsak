<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\{Instruction, Client, Currency};
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

	public function clients()
	{
		return $this->belongsTo(Client::class);
	}

	public function instructions()
	{
		return $this->belongsTo(Client::class);
	}

	public function currency()
	{
		return $this->belongsTo(Client::class);
	}
}
