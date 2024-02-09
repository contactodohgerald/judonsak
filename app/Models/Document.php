<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\{Contract, Instruction, Client};
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;


    protected $dates = ['deleted_at'];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

	public function contract()
	{
		return $this->belongsTo(Contract::class);
	}

    public function logs()
    {
        return $this->morphMany('App\Models\Log', 'logable');
    }

	public function instruction()
	{
		return $this->belongsTo(Instruction::class);
	}
}
