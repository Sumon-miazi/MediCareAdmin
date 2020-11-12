<?php

namespace App\Http\Controllers;

use App\Appointment;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppointmentController extends Controller
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
     * @return JsonResponse
     */
    public function bookNewAppointment(Request $request)
    {
        $status = false;
        $validator = Validator()->make($request->all(), [
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'doctor_chamber_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        $appointmentTime = Carbon::create($request->year, $request->month, $request->day, $request->hour, $request->minute, 0);

        $appointment = new Appointment([
            'patient_id' => $request->get('patient_id'),
            'doctor_id' => $request->get('doctor_id'),
            'doctor_chamber_id' => $request->get('doctor_chamber_id'),
            'appointmentTime' => $appointmentTime,
            'status' => $request->get('status')
        ]);

        $appointment->save();
        $status = true;
        return response()->json(['status' => $status, 'message' => 'Appointment added sucessfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param Appointment $appointment
     * @return Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Appointment $appointment
     * @return Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Appointment $appointment
     * @return Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Appointment $appointment
     * @return Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
