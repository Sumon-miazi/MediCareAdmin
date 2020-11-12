<?php

namespace App\Http\Controllers;

use App\Hospital;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HospitalController extends Controller
{

    public function test(Request $request)
    {
        $hospital = Hospital::find($request->id);
        return $hospital->doctors();
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $allHospitals = Hospital::all();
        return response()->json(['status' => 'true', 'data' => $allHospitals, 'message' => 'Test api']);
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
    public function store(Request $request){
        $status = false;
        $validator = Validator()->make($request->all(), [
            'name'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'lat'=>'required',
            'long'=>'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        $hospital = new Hospital([
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'phone' => $request->get('phone'),
            'lat' => $request->get('lat'),
            'long' => $request->get('long')
        ]);

        $hospital->save();
        $status = true;
        return response()->json(['status' => $status, 'message' => 'Hospital added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param Hospital $hospital
     * @return Response
     */
    public function show(Hospital $hospital)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Hospital $hospital
     * @return Response
     */
    public function edit(Hospital $hospital)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Hospital $hospital
     * @return Response
     */
    public function update(Request $request, Hospital $hospital)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Hospital $hospital
     * @return Response
     */
    public function destroy(Hospital $hospital)
    {
        //
    }
}
