<?php

namespace App\Http\Controllers;

use App\BloodDonor;
use App\Patient;
use App\BloodBank;
use App\Doctor;
use App\DiagnosticCenter;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Storage;
use Image;

class PatientController extends Controller
{

    public function store(Request $request)
    {
        $status = false;
        $validator = Validator()->make($request->all(), [
            'name' => 'required',
            'uid' => 'required'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        if (Patient::where('uid', $request->uid)->exists()) {
            $patient = Patient::where("uid", $request->uid)->first();
            $patient->name = $request->get('name');
            $patient->gender = $request->get('gender');
            $patient->is_blood_donor = $request->get('is_blood_donor');
            $patient->dob = $request->get('dob');
            $patient->weight = $request->get('weight');
            $patient->blood_group = $request->get('blood_group');
            $patient->address = $request->get('address');
            $patient->phone = $request->get('phone');
            $patient->token = $request->get('token');


            if ($request->hasFile('image')) {
                //  Let's do everything here
                if ($request->file('image')->isValid()) {
                    //
                    $validated = $request->validate([
                        'image' => 'mimes:jpeg,png,svg',
                    ]);
                    $extension = $request->image->extension();

                    $file = $request->file('image');
                    $fileNameToStore = $request->get('uid').".".$extension;

                    $save = $this->resizeImage($file, $fileNameToStore);

                    if($save){
                        $patient->image = 'patients/' . $fileNameToStore;
                    }
                }
            }


            $patient->save();


            if ($request->get('is_blood_donor') == true) {
                if (BloodDonor::where('patient_id', $patient->id)->exists()) {
                    $bloodDonor = BloodDonor::where('patient_id', $patient->id)->first();
                    $bloodDonor->lastDonate = $request->get('lastDonate');
                    $bloodDonor->currentlyAvailable = true;
                    $bloodDonor->save();
                }
            }

            $status = true;
            return response()->json(['status' => $status, 'data' => $patient, 'message' => 'patient found']);
        }

        $patient = new Patient([
            'name' => $request->get('name'),
            'uid' => $request->get('uid'),
            'gender' => $request->get('gender'),
            'is_blood_donor' => $request->get('is_blood_donor'),
            'dob' => $request->get('dob'),
            'weight' => $request->get('weight'),
            'blood_group' => $request->get('blood_group'),
            'address' => $request->get('address'),
            'phone' => $request->get('phone'),
            'token' => $request->get('token')
        ]);


        if ($request->hasFile('image') && $request->hasFile('image') != null) {
            //  Let's do everything here
            if ($request->file('image')->isValid()) {
                //
                $validated = $request->validate([
                    'image' => 'mimes:jpeg,png,svg',
                ]);
                $extension = $request->image->extension();

                $file = $request->file('image');
                $fileNameToStore = $request->get('uid').".".$extension;

                $save = $this->resizeImage($file, $fileNameToStore);

               // $request->image->storeAs('/public/patients', $fileNameToStore);
                if($save){
                    $patient->image = 'patients/' . $fileNameToStore;
                }
            }
        }



        $patient->save();

        if ($request->get('is_blood_donor') == true) {
            $bloodDonor = new BloodDonor([
                'patient_id' => $patient->id,
                'lastDonate' => $request->get('lastDonate'),
                'currentlyAvailable' => true
            ]);

            $bloodDonor->save();
        }

        $status = true;
        return response()->json(['status' => $status, 'data' => $patient, 'message' => 'Patient added successfully']);

    }

    public function resizeImage($file, $fileNameToStore) {
      // Resize image
      $resize = Image::make($file)->resize(200, null, function ($constraint) {
        $constraint->aspectRatio();
      })->encode('jpg');

      $save = Storage::put("public/patients/{$fileNameToStore}", $resize->__toString());

      if($save) {
        return true;
      }
      return false;
    }



    public function getPatientDetailsByUid(Request $request)
    {
        $status = false;
        $validator = Validator()->make($request->all(), [
            'uid' => 'required'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        if (Patient::where('uid', $request->uid)->exists()) {
            $patient = Patient::where("uid", $request->uid)->first();
            $status = true;
            return response()->json(['status' => $status, 'data' => $patient, 'message' => 'patient found']);
        } else {
            $status = false;
            return response()->json(['status' => $status, 'data' => null, 'message' => 'user not found']);
        }
    }


    public function checkUserExistenceByUid(Request $request)
    {
        $status = false;

        $validator = Validator()->make($request->all(), [
            'uid' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        $status = true;

        if (Patient::where('uid', $request->uid)->exists()) {
            $data = Patient::where('uid', $request->uid)->first();
            return response()->json(['status' => $status, 'data' => $data ,'message' => 'user found', 'userType' => 'patient']);
        }

        else if (Doctor::where('uid', $request->uid)->exists()) {
            $data = Doctor::where('uid', $request->uid)->first();
            return response()->json(['status' => $status, 'data' => $data ,'message' => 'user found', 'userType' => 'doctor']);
        }
        else if (BloodBank::where('uid', $request->uid)->exists()) {
            $data = BloodBank::where('uid', $request->uid)->first();
            return response()->json(['status' => $status, 'data' => $data ,'message' => 'user found', 'userType' => 'bloodBank']);
        }
        else if (DiagnosticCenter::where('uid', $request->uid)->exists()) {
            $data = DiagnosticCenter::where('uid', $request->uid)->first();
            return response()->json(['status' => $status, 'data' => $data ,'message' => 'user found', 'userType' => 'diagnosticCenter']);
        }
        else {
            $status = false;
            return response()->json(['status' => $status, 'message' => 'user not found']);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param Patient $patient
     * @return Response
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Patient $patient
     * @return Response
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Patient $patient
     * @return Response
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Patient $patient
     * @return Response
     */
    public function destroy(Patient $patient)
    {
        //
    }

    public function testCloudMessage()
    {
        $messaging = app('firebase.messaging');

        $title = 'Test notification';
        $body = 'yeah...it is working';

        $deviceToken = 'eKLBX7WVSv2sfWQRhqb0ZQ:APA91bHAGskdrlGpegwhpH9njN6C9VXQdgaqYVVI018XSk3ECafS8IC80_3rOo5W9F_t2hk2_uIDP_EVSbYBnnCju8Sz_sHop9L589k2DeTPPIqOvYOTf_8xoBbwIvKu5NLftZ4yUO_9';

        $notification = Notification::create($title, $body);

        $data = [
            'first_key' => 'First Value',
            'second_key' => 'Second Value',
        ];

        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification($notification) // optional
            ->withData($data) // optional
        ;

        $messaging->send($message);
    }
}
