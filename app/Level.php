<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
	// this model shows which level the staff is in the company
    public function people()
    {
     return $this->hasMany(Level::class);
    }

}
