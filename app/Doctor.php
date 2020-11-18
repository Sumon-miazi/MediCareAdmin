<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'uid',
        'name',
        'bmdcRegNo',
        'specialist',
        'gender',
        'about',
        'educationHistory',
        'address',
        'email',
        'phone',
        'token'
    ];

    public function doctor_chambers()
    {
        // return $this->hasMany('App\DoctorChamber', 'doctor_id', 'id');
        return $this->hasMany('App\DoctorChamber');
    }
}
