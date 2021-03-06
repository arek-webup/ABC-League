<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public function accounts()
    {
        return $this->belongsTo('App\Account');
    }

    public function account()
    {
        return $this->hasMany('App\Account');
    }
}
