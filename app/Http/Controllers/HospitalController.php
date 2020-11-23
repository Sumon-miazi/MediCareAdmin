<?php

namespace App\Http\Controllers;

use App\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{

    public function index()
    {
        $allHospitals = Hospital::all();
        return response()->json(['status' => 'true', 'data' => $allHospitals, 'message' => 'Test api']);
    }

    public function store(Request $request){
        $status = false;
        $validator = Validator()->make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        $hospital = new Hospital([
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'phone' => $request->get('phone'),
            'latitude' => $request->get('lat'),
            'longitude' => $request->get('long')
        ]);

        $hospital->save();
        $status = true;
        return response()->json(['status' => $status, 'message' => 'Hospital added successfully']);
    }
}
