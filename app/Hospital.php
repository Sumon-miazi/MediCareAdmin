<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'lat',
        'long'
    ];

    public function doctors()
    {
        // return $this->hasMany('App\DoctorChamber', 'doctor_id', 'id');
        return $this->hasMany('App\Doctor');
    }

    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }

    /*
        private function findNearestRestaurants($latitude, $longitude, $radius = 400)
        {
             //* using eloquent approach, make sure to replace the "Restaurant" with your actual model name
             //* replace 6371000 with 6371 for kilometer and 3956 for miles

            $restaurants = Restaurant::selectRaw("id, name, address, latitude, longitude, rating, zone ,
                             ( 6371000 * acos( cos( radians(?) ) *
                               cos( radians( latitude ) )
                               * cos( radians( longitude ) - radians(?)
                               ) + sin( radians(?) ) *
                               sin( radians( latitude ) ) )
                             ) AS distance", [$latitude, $longitude, $latitude])
                ->where('active', '=', 1)
                ->having("distance", "<", $radius)
                ->orderBy("distance",'asc')
                ->offset(0)
                ->limit(20)
                ->get();

            return $restaurants;
        }
        */
}
