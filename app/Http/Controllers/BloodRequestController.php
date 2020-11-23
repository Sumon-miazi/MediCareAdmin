<?php

namespace App\Http\Controllers;

use App\BloodRequest;
use Illuminate\Http\Request;

class BloodRequestController extends Controller
{

    public function index()
    {
        $bloodRequestArray = BloodRequest::all();
        foreach ($bloodRequestArray as $bloodRequest) {
            $bloodRequest->patient;
        }
        return response()->json(['status' => 'true', 'data' => $bloodRequestArray, 'message' => 'all blood request']);
    }


    public function addNewBloodRequest(Request $request)
    {
        $status = false;
        $validator = Validator()->make($request->all(), [
            'patient_id' => 'required',
            'bloodFor' => 'required',
            'city' => 'required',
            'hospital' => 'required',
            'amount' => 'required',
            'bloodGroup' => 'required',
            'date' => 'required'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        $status = true;

        if (BloodRequest::where('patient_id', $request->get('patient_id'))->exists()) {
            $bloodRequest = BloodRequest::where("patient_id", $request->get('patient_id'))->first();

            $bloodRequest->bloodFor = $request->get('bloodFor');
            $bloodRequest->city = $request->get('city');
            $bloodRequest->hospital = $request->get('hospital');
            $bloodRequest->amount = $request->get('amount');
            $bloodRequest->bloodGroup = $request->get('bloodGroup');
            $bloodRequest->date = $request->get('date');
            $bloodRequest->save();

            return response()->json(['status' => $status, 'data' => $bloodRequest, 'message' => 'Request updated successfully']);
        }

            $bloodRequest = new BloodRequest([
                'patient_id' => $request->get('patient_id'),
                'bloodFor' => $request->get('bloodFor'),
                'city' => $request->get('city'),
                'hospital' => $request->get('hospital'),
                'amount' => $request->get('amount'),
                'bloodGroup' => $request->get('bloodGroup'),
                'date' => $request->get('date')
            ]);

            $bloodRequest->save();

        return response()->json(['status' => $status, 'data' => $bloodRequest, 'message' => 'Request added successfully']);
    }
}
