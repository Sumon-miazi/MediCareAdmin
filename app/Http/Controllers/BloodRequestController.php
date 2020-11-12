<?php

namespace App\Http\Controllers;

use App\BloodRequest;
use Illuminate\Http\Request;

class BloodRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BloodRequest  $bloodRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(BloodRequest $bloodRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BloodRequest  $bloodRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BloodRequest $bloodRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BloodRequest  $bloodRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(BloodRequest $bloodRequest)
    {
        //
    }
}
