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
}
