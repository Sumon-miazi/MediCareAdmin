<?php

namespace App\Http\Controllers;

use App\Specialist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $specialist = Specialist::all();
        return response()->json(['status' => 'true', 'data' => $specialist, 'message' => 'all specialist return']);
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

}
