<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Hospital;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DoctorController extends Controller
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

    public function getAllDoctorByHospitalId(Request $request)
    {
        $status = false;

        $validator = Validator()->make($request->all(), [
            'hospital_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        $status = true;
        $hospital = Hospital::find($request->hospital_id);

        return response()->json(['status' => $status, 'data' => $hospital->doctors, 'message' => 'all doctor by hospital id sent successfully']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Doctor $doctor
     * @return Response
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Doctor $doctor
     * @return Response
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Doctor $doctor
     * @return Response
     */
    public function update(Request $request, Doctor $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Doctor $doctor
     * @return Response
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}
