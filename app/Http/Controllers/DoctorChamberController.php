<?php

namespace App\Http\Controllers;

use App\Doctor;
use Illuminate\Http\Request;

class DoctorChamberController extends Controller
{


    public function getDoctorChambers(Request $request)
    {
        $status = false;

        $validator = Validator()->make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }
//return $request;
        $status = true;

        $doctorChamberArray = Doctor::find($request->id)->doctor_chambers;
        // $doctorChamberObj = DoctorChamber::where('id',$request->id)->get();
        foreach ($doctorChamberArray as $doctorChamber) {
            $doctorChamber->hospital;
            $availableDays = $doctorChamber->availableDays;
            foreach ($availableDays as $availableDay) {
                $availableDay->available_times;
            }
        }
        return response()->json(['status' => $status, 'data' => $doctorChamberArray, 'message' => 'all doctor chamber by doctor id sent successfully']);

    }
}
