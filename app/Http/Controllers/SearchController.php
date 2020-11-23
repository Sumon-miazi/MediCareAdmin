<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{
    public function searchNearBy(Request $request)
    {

        return $this->findNearestHospitals($request->latitude, $request->longitude, $request->radius);
    }


    private function findNearestHospitals($latitude, $longitude, $radius)
    {
        /*
 * using query builder approach, useful when you want to execute direct query
 * replace 6371000 with 6371 for kilometer and 3956 for miles
 */
        $hospitals = DB::table('diagnostic_centers')
            ->selectRaw('id,
        user_id,
         name,
         approved,
         image,
         uid,
         services,
         address,
         email,
         phone,
         token,
         latitude,
         longitude,
         ( 6371 * acos( cos( radians(?) )
         * cos( radians( latitude ) )
         * cos( radians(longitude ) - radians(?)) + sin( radians(?) )
         * sin( radians( latitude ) ) ))
         AS distance', [$latitude, $longitude, $latitude])
            ->where('approved', '=', 1)
            ->having("distance", "<", $radius)
            ->orderBy("distance", 'asc')
            ->offset(0)
            ->limit(20)
            ->get();

        return $hospitals;
    }

    private function findNearestDiagnosticCenters($latitude, $longitude, $radius)
    {
        /*
 * using query builder approach, useful when you want to execute direct query
 * replace 6371000 with 6371 for kilometer and 3956 for miles
 */
        $result = DB::table('diagnostic_centers')
            ->selectRaw('id,
        user_id,
         name,
         approved,
         image,
         uid,
         services,
         address,
         email,
         phone,
         token,
         latitude,
         longitude,
         ( 6371 * acos( cos( radians(?) )
         * cos( radians( latitude ) )
         * cos( radians(longitude ) - radians(?)) + sin( radians(?) )
         * sin( radians( latitude ) ) ))
         AS distance', [$latitude, $longitude, $latitude])
            ->where('approved', '=', 1)
            ->having("distance", "<", $radius)
            ->orderBy("distance", 'asc')
            ->offset(0)
            ->limit(20)
            ->get();

        return $result;
    }

    private function findNearestBloodBanks($latitude, $longitude, $radius)
    {
        /*
 * using query builder approach, useful when you want to execute direct query
 * replace 6371000 with 6371 for kilometer and 3956 for miles
 */
        $result = DB::table('diagnostic_centers')
            ->selectRaw('id,
        user_id,
         name,
         approved,
         image,
         uid,
         services,
         address,
         email,
         phone,
         token,
         latitude,
         longitude,
         ( 6371 * acos( cos( radians(?) )
         * cos( radians( latitude ) )
         * cos( radians(longitude ) - radians(?)) + sin( radians(?) )
         * sin( radians( latitude ) ) ))
         AS distance', [$latitude, $longitude, $latitude])
            ->where('approved', '=', 1)
            ->having("distance", "<", $radius)
            ->orderBy("distance", 'asc')
            ->offset(0)
            ->limit(20)
            ->get();

        return $result;
    }
}
