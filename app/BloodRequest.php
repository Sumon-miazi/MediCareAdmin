<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    //
    protected $fillable = [
        'patient_id',
        'bloodFor',
        'city',
        'hospital',
        'amount',
        'bloodGroup',
        'date'
    ];
    protected $dates = ['date'];
    
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }
}