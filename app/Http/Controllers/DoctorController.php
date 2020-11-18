<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Hospital;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

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

            $url = null;

            if ($request->hasFile('image') && $request->hasFile('image') != null) {
                //  Let's do everything here
                if ($request->file('image')->isValid()) {
                    //
                    $validated = $request->validate([
                        'image' => 'mimes:jpeg,png',
                    ]);
                    $extension = $request->image->extension();
                    $request->image->storeAs('/public/doctor', $request->get('uid').".".$extension);
                    $url = Storage::url('doctor/' . $request->get('uid').".".$extension);
                }
            }

            $doctor->image = $url;

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

        $url = null;

        if ($request->hasFile('image') && $request->hasFile('image') != null) {
            //  Let's do everything here
            if ($request->file('image')->isValid()) {
                //
                $validated = $request->validate([
                    'image' => 'mimes:jpeg,png',
                ]);
                $extension = $request->image->extension();
                $request->image->storeAs('/public/doctor', $request->get('uid').".".$extension);
                $url = Storage::url('doctor/' . $request->get('uid').".".$extension);
            }
        }

        $doctor->image = $url;

        $doctor->save();


        $status = true;
        return response()->json(['status' => $status, 'data' => $doctor, 'message' => 'doctor added successfully']);

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
