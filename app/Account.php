<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function regions()
    {
        return $this->belongsTo('App\Region');
    }

    public function region()
    {
        return $this->hasOne('App\Region');
    }

    public function codes()
    {
        return $this->belongsTo('App\Code');
    }

    public function code()
    {
        return $this->hasOne('App\Code');
    }
}
