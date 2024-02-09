<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenditure_category extends Model
{
    public function expenditures()
    {
        return $this->hasMany(Expenditure::class);
    }
}
