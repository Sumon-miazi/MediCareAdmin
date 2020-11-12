<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailableDay extends Model
{
    //

    public function available_times()
    {
        return $this->belongsToMany('App\AvailableTime', 'available_day_available_times');
    }
}
