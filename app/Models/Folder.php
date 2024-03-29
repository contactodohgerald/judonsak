<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

}
