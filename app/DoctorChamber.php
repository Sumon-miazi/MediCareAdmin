<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorChamber extends Model
{
    //

    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }

    public function availableDays()
    {
        return $this->belongsToMany('App\AvailableDay', 'available_day_doctor_chambers');
    }
}
