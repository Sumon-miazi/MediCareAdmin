<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BloodBank extends Model
{
    protected $fillable = [
    	'uid',
        'name',
        'about',
        'address',
        'email',
        'phone',
        'token',
        'lat',
        'long'
    ];
}
