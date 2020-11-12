<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //
    protected $fillable = [
        'name',
        'uid',
        'gender',
        'is_blood_donor',
        'dob',
        'weight',
        'blood_group',
        'address',
        'phone',
        'token'
    ];

    public function bloodDonor()
    {
        return $this->hasOne('App\BloodDonor');
    }

    public function bloodRequest()
    {
        return $this->hasOne('App\BloodRequest');
    }
}
