<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\DoctorChamber;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DoctorChamberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function getDoctorChambers(Request $request)
    {
        $status = false;

        $validator = Validator()->make($request->all(), [
            'doctor_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }
//return $request;
        $status = true;

        $doctorChamberArray = Doctor::find($request->doctor_id)->doctor_chambers;
        // $doctorChamberObj = DoctorChamber::where('doctor_id',$request->doctor_id)->get();
        foreach ($doctorChamberArray as $doctorChamber) {
            $doctorChamber->hospital;
            $availableDays = $doctorChamber->availableDays;
            foreach ($availableDays as $availableDay) {
                $availableDay->available_times;
            }
        }
        return response()->json(['status' => $status, 'data' => $doctorChamberArray, 'message' => 'all doctor chamber by doctor id sent successfully']);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DoctorChamber $doctorChamber
     * @return void
     */
    public function edit(DoctorChamber $doctorChamber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param DoctorChamber $doctorChamber
     * @return void
     */
    public function update(Request $request, DoctorChamber $doctorChamber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DoctorChamber $doctorChamber
     * @return void
     */
    public function destroy(DoctorChamber $doctorChamber)
    {
        //
    }
}
