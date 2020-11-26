<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{
    public function searchNearBy(Request $request)
    {
        $status = false;
        $validator = Validator()->make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
            'radius' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }
        $status = true;
        if($request->name == 'hospitals'){
            $data =  $this->findNearestHospitals($request->latitude, $request->longitude, $request->radius);
            return response()->json(['status' => $status, 'data' => $data, 'message' => 'nearest hospitals return']);
        }
        else if($request->name == 'diagnostic centers'){
            $data = $this->findNearestDiagnosticCenters($request->latitude, $request->longitude, $request->radius);
            return response()->json(['status' => $status, 'data' => $data, 'message' => 'nearest diagnostics return']);
        }
        else if($request->name == 'blood banks'){
            $data = $this->findNearestBloodBanks($request->latitude, $request->longitude, $request->radius);
            return response()->json(['status' => $status, 'data' => $data, 'message' => 'nearest blood banks return']);
        }
        else if($request->name == 'pharmacies'){
            $data = $this->findNearestPharmacies($request->latitude, $request->longitude, $request->radius);
            return response()->json(['status' => $status, 'data' => $data, 'message' => 'nearest pharmacies return']);
        }
        return response()->json(['status' => false, 'message' => "conditions not fulfill"]);
    }


    private function findNearestHospitals($latitude, $longitude, $radius)
    {
        /*
 * using query builder approach, useful when you want to execute direct query
 * replace 6371000 with 6371 for kilometer and 3956 for miles
 */
        $data = DB::table('hospitals')
            ->selectRaw('id,
         name,
         approved,
         image,
         address,
         phone,
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

        return $data;
    }

    private function findNearestDiagnosticCenters($latitude, $longitude, $radius)
    {
        /*
 * using query builder approach, useful when you want to execute direct query
 * replace 6371000 with 6371 for kilometer and 3956 for miles
 */
        $data = DB::table('diagnostic_centers')
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

        return $data;
    }

    private function findNearestBloodBanks($latitude, $longitude, $radius)
    {
        /*
 * using query builder approach, useful when you want to execute direct query
 * replace 6371000 with 6371 for kilometer and 3956 for miles
 */

        $data = DB::table('blood_banks')
            ->selectRaw('id,
         name,
         uid,
         image,
         about,
         address,
         email,
         phone,
         token,
         approved,
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

        return $data;
    }


    private function findNearestPharmacies($latitude, $longitude, $radius)
    {
        /*
 * using query builder approach, useful when you want to execute direct query
 * replace 6371000 with 6371 for kilometer and 3956 for miles
 */

        $data = DB::table('pharmacies')
            ->selectRaw('id,
         name,
         uid,
         image,
         about,
         address,
         email,
         phone,
         token,
         approved,
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

        return $data;
    }
}
