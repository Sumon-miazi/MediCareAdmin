<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'doctor_chamber_id',
        'appointmentTime',
        'status'
    ];

    protected $dates = ['appointmentTime'];


    public function reports()
    {
        return $this->hasMany('App\Report');
    }

    public function doctor_chamber()
    {
        return $this->belongsTo('App\DoctorChamber');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }

}
