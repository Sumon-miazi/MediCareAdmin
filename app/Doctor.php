<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'hospital_id',
        'dob',
        'education_history',
        'address',
        'phone'
    ];

    public function doctor_chambers()
    {
        // return $this->hasMany('App\DoctorChamber', 'doctor_id', 'id');
        return $this->hasMany('App\DoctorChamber');
    }
}
