<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
	protected $fillable = [
        'name',
    ];

    public function diagnosticCenters()
    {
        return $this->belongsToMany('App\DiagnosticCenter', 'diagnostic_services');
    }
}
