<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailableTime extends Model
{
    //

    public function doctor_chambers()
    {
        return $this->belongsToMany('App\AvailableDay', 'available_day_available_times');
    }
}
