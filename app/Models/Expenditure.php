<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    protected $fillable = [ 
        'description', 
        'budget_id', 
        'expenditure_category_id', 
        'gross', 
        'employer_cost', 
        'total', 
        'status_id',
        'remark'
    ];

    public function expenditure_category()
    {
        return $this->belongsTo(Expenditure_category::class);
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
