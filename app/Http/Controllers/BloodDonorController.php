<?php

namespace App\Http\Controllers;

use App\Patient;
use App\BloodDonor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BloodDonorController extends Controller
{

    public function getDonorList(Request $request)
    {
        $allDonor = BloodDonor::all();
        foreach ($allDonor as $donor) {
            $donor->patient;
        }
        return response()->json(['status' => 'true', 'data' => $allDonor, 'message' => 'All blood donor']);
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
    public function addBloodDonor(Request $request)
    {
        $status = false;
        $validator = Validator()->make($request->all(), [
            'patient_id' => 'required',
            'lastDonate' => 'required',
            'currentlyAvailable' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        if (BloodDonor::where('patient_id', $request->get('patient_id'))->exists()) {
            $bloodDonor = BloodDonor::where('patient_id', $request->get('patient_id'))->first();
            $bloodDonor->lastDonate = $request->get('lastDonate');
            $bloodDonor->currentlyAvailable = $request->get('currentlyAvailable');

            $bloodDonor->save();

            $patient = Patient::find($request->get('patient_id'));
            $patient->is_blood_donor = true;
            $patient->save();

            $status = true;
            return response()->json(['status' => $status, 'data' => $bloodDonor, 'message' => 'Blood donor added successfully']);
        }

        $bloodDonor = new BloodDonor([
            'patient_id' => $request->get('patient_id'),
            'lastDonate' => $request->get('lastDonate'),
            'currentlyAvailable' => $request->get('currentlyAvailable')
        ]);

        $bloodDonor->save();

        $patient = Patient::find($request->get('patient_id'));
        $patient->is_blood_donor = true;
        $patient->save();

        $status = true;
        return response()->json(['status' => $status, 'message' => 'Blood donor added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param BloodDonor $bloodDonor
     * @return Response
     */
    public function show(BloodDonor $bloodDonor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BloodDonor $bloodDonor
     * @return Response
     */
    public function edit(BloodDonor $bloodDonor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param BloodDonor $bloodDonor
     * @return Response
     */
    public function update(Request $request, BloodDonor $bloodDonor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BloodDonor $bloodDonor
     * @return Response
     */
    public function destroy(BloodDonor $bloodDonor)
    {
        //
    }
}
