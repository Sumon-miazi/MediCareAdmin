<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    protected $fillable = [
        'uid',
        'name',
        'about',
        'address',
        'email',
        'phone',
        'token',
        'latitude',
        'longitude'
    ];
}
