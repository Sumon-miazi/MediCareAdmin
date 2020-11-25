<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiagnosticCenterService extends Model
{
	protected $fillable = [
        'diagnostic_center_id',
        'service_id',
    ];
}
