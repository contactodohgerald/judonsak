<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Revenue extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'description', 
    	'client_id', 
    	'status_id', 
    	'budget_id', 
    	'currency_id', 
    	'category_id', 
    	'payment_id',
    	'issue_date', 
    	'total', 
    	'remark' 
    ];

	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function budget()
	{
		return $this->belongsTo(Budget::class);
	}

	public function payment()
	{
		return $this->belongsTo(Payment::class);
	}

	public function currency()
	{
		return $this->belongsTo(Currency::class);
	}

	public function status()
	{
		return $this->belongsTo(Status::class);
	}
}
