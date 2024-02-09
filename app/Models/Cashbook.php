<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cashbook extends Model
{
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function cashbook_label()
    {
        return $this->belongsTo(Cashbook_label::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function logs()
    {
        return $this->morphMany('App\Models\Log', 'logable');
    }

}
