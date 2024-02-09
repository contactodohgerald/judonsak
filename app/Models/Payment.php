<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = array(
        'contract_id',
        'percent',
        'due_date'
    );

    public function contract()
    {
        return $this->belongsTo('App\Models\Contract');
    }
    
    public function status()
    {
        return $this->belongsTo('App\Models\Status');
    }
    
    public function logs()
    {
        return $this->morphMany('App\Models\Log', 'logable');
    }
}
