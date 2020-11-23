<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class DoctorController extends Controller
{


    public function getAllDoctorByHospitalId(Request $request)
    {
        $status = false;

        $validator = Validator()->make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        $status = true;
        $hospital = Hospital::find($request->id);

        return response()->json(['status' => $status, 'data' => $hospital->doctors, 'message' => 'all doctor by hospital id sent successfully']);
    }




    public function getDoctorDataByUid(Request $request)
    {
        $status = false;
        $validator = Validator()->make($request->all(), [
            'uid' => 'required'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        if (Doctor::where('uid', $request->uid)->exists()) {
            $doctor = Doctor::where("uid", $request->uid)->first();
            $status = true;
            return response()->json(['status' => $status, 'data' => $doctor, 'message' => 'doctor found']);
        } else {
            $status = false;
            return response()->json(['status' => $status, 'data' => null, 'message' => 'user not found']);
        }
    }

    public function store(Request $request)
    {
        $status = false;
        $validator = Validator()->make($request->all(), [
            'name' =>'required',
            'uid' =>'required',
            'gender' =>'required',
            'bmdcRegNo' =>'required',
            'address' =>'required',
            'email' =>'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }


        if (Doctor::where('uid', $request->uid)->exists()) {
            $doctor = Doctor::where("uid", $request->uid)->first();
            $doctor->name = $request->get('name');
            $doctor->gender = $request->get('gender');
            $doctor->bmdcRegNo = $request->get('bmdcRegNo');
            $doctor->specialist = $request->get('specialist');
            $doctor->about = $request->get('about');
            $doctor->educationHistory = $request->get('educationHistory');
            $doctor->email = $request->get('email');
            $doctor->address = $request->get('address');
            $doctor->phone = $request->get('phone');
            $doctor->token = $request->get('token');

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
                        $doctor->image = 'doctors/' . $fileNameToStore;
                    }
                }
            }

            $doctor->save();

            $status = true;
            return response()->json(['status' => $status, 'data' => $doctor, 'message' => 'doctor found']);
        }

        $doctor = new Doctor([
            'uid' => $request->get('uid'),
            'name' => $request->get('name'),
            'bmdcRegNo' => $request->get('bmdcRegNo'),
            'specialist' => $request->get('specialist'),
            'gender' => $request->get('gender'),
            'about' => $request->get('about'),
            'educationHistory' => $request->get('educationHistory'),
            'address' => $request->get('address'),
            'email' => $request->get('email'),
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
                    $doctor->image = 'doctors/' . $fileNameToStore;
                }
            }
        }

        $doctor->save();


        $status = true;
        return response()->json(['status' => $status, 'data' => $doctor, 'message' => 'doctor added successfully']);

    }

    public function resizeImage($file, $fileNameToStore) {
      // Resize image
      $resize = Image::make($file)->resize(200, null, function ($constraint) {
        $constraint->aspectRatio();
      })->encode('jpg');

      $save = Storage::put("public/doctors/{$fileNameToStore}", $resize->__toString());

      if($save) {
        return true;
      }
      return false;
    }

}
