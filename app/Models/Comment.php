<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name', 'body', 'status'
    ];

	public function tasks()
	{
		$this->morphTo(Task::class);
	}

	public function instructions()
	{
		$this->morphTo(Instruction::class);
	}

	public function statuses()
	{
		$this->belongsTo(Status::class);
	}
}
