<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BloodDonor extends Model
{
    protected $fillable = [
        'patient_id',
        'lastDonate',
        'currentlyAvailable'
    ];

    protected $dates = ['lastDonate'];

    public function user()
    {
        // return $this->hasMany('App\DoctorChamber', 'doctor_id', 'id');
        return $this->belongsTo('App\Patient');
    }
}
