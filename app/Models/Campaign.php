<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    public function inputs()
    {
        return $this->hasMany(Input::class);
    }
}
