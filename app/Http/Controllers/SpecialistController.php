<?php

namespace App\Http\Controllers;

use App\Specialist;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $specialist = Specialist::all();
        return response()->json(['status' => 'true', 'data' => $specialist, 'message' => 'all specialist return']);
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


    public function getAllDoctorBySpecialistId(Request $request)
    {
        $status = false;
        $validator = Validator()->make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        $specialist = Specialist::find($request->id);
        $doctors = $specialist->doctors;
        $status = true;
        return response()->json(['status' => $status, 'data' => $doctors, 'message' => 'all doctor related to specialist has returned']);
    }

    /**
     * Display the specified resource.
     *
     * @param Specialist $specialist
     * @return Response
     */
    public function show(Specialist $specialist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Specialist $specialist
     * @return Response
     */
    public function edit(Specialist $specialist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Specialist $specialist
     * @return Response
     */
    public function update(Request $request, Specialist $specialist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Specialist $specialist
     * @return Response
     */
    public function destroy(Specialist $specialist)
    {
        //
    }
}
