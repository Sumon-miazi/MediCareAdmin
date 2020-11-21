<?php

namespace App\Http\Controllers;

use App\Appointment;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppointmentController extends Controller
{

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
        date_default_timezone_set('Asia/Dhaka');
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


    public function getNextAppointment(Request $request)
    {
        date_default_timezone_set('Asia/Dhaka');
        $status = false;
        $validator = Validator()->make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        $appointment = Appointment::where('patient_id', $request->get('id'))
            ->where('appointmentTime', '>=', Carbon::now()->toDateString())
            ->where('status', 1)
            ->orderBy('appointmentTime', 'asc')
            ->first();

        if($appointment == null){
            $status = false;
            return response()->json(['status' => $status,'data' => null, 'message' => 'Appointment not found']);
        }
        $appointment->doctor;
        $appointment->doctor_chamber->hospital;

        $status = true;
        return response()->json(['status' => $status,'data' => $appointment, 'message' => 'Appointment return sucessfully']);
    }


    public function getAllAppointment(Request $request)
    {
        date_default_timezone_set('Asia/Dhaka');
        $status = false;
        $validator = Validator()->make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        $appointments = Appointment::where('patient_id', $request->get('id'))
            ->where('appointmentTime', '>=', Carbon::now()->toDateString())
            ->orderBy('appointmentTime', 'asc')
            ->get();

        $oldAppointments = Appointment::where('patient_id', $request->get('id'))
            ->where('appointmentTime', '<', Carbon::now()->toDateString())
            ->orderBy('appointmentTime', 'asc')
            ->get();

        foreach ($appointments as $appointment) {
            $appointment->doctor;
            $appointment->doctor_chamber->hospital;
        }

        foreach ($oldAppointments as $oldAppointment) {
            $oldAppointment->doctor;
            $oldAppointment->doctor_chamber->hospital;
        }


        $status = true;
        return response()->json(['status' => $status,'data' => $appointments, 'oldData' => $oldAppointments, 'message' => 'Appointment return sucessfully']);
    }

    public function getAnAppointmentReports(Request $request)
    {
        date_default_timezone_set('Asia/Dhaka');
        $status = false;
        $validator = Validator()->make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        $appointment = Appointment::find($request->get('id'));

        $reports = $appointment->reports;
        foreach ($reports as $report) {
            $report->file = json_decode($report->file);
            $report->diagnostic_center;
        }
        

        $status = true;
        return response()->json(['status' => $status,'data' => $reports , 'message' => 'Appointment reports return sucessfully']);
    }
}
