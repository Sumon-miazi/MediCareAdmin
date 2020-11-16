<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiagnosticCenter extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function reports()
    {
        return $this->hasMany('App\Report');
    }
}
