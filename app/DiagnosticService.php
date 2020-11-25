<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiagnosticService extends Model
{
	protected $fillable = [
        'diagnostic_center_id',
        'service_id',
    ];
}
