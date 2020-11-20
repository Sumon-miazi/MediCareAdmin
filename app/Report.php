<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'diagnostic_center_id',
        'patient_id',
        'title'
    ];

    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }


    public function diagnostic_center()
    {
        return $this->belongsTo('App\DiagnosticCenter');
    }


    public function appointment()
    {
        return $this->belongsTo('App\Appointment');
    }
}
