<?php

namespace App\Http\Controllers;

use App\BloodBank;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BloodBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getAllBloodBank()
    {
        $allBloodBank = BloodBank::all();
        return response()->json(['status' => 'true', 'data' => $allBloodBank, 'message' => 'All blood bank']);
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

    public function getBloodBankDataByUid(Request $request){
        $status = false;
        $validator = Validator()->make($request->all(), [
            'uid' => 'required'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        if (BloodBank::where('uid', $request->uid)->exists()) {
            $bloodBank = BloodBank::where("uid", $request->uid)->first();
            $status = true;
            return response()->json(['status' => $status, 'data' => $bloodBank, 'message' => 'blood bank found']);
        } else {
            $status = false;
            return response()->json(['status' => $status, 'data' => null, 'message' => 'user not found']);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        /*
            $table->string('name');
            $table->string('uid')->nullable();
            $table->string('image')->nullable();
            $table->mediumText('about');
            $table->mediumText('address');
            $table->string('phone');
            $table->string('token')->nullable();
            $table->decimal('lat', 10, 7);
            $table->decimal('long', 10, 7);
            */

        $status = false;
        $validator = Validator()->make($request->all(), [
            'name'=>'required',
            'uid'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'about'=>'required',
            'email'=>'required',
            'token'=>'required',
            'lat'=>'required',
            'long'=>'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        $status = true;

        if (BloodBank::where('uid', $request->uid)->exists()) {
            $bloodBank = BloodBank::where("uid", $request->uid)->first();
            $bloodBank->name = $request->get('name');
            $bloodBank->about = $request->get('about');
            $bloodBank->address = $request->get('address');
            $bloodBank->phone = $request->get('phone');
            $bloodBank->email = $request->get('email');
            $bloodBank->token = $request->get('token');
            $bloodBank->lat = $request->get('lat');
            $bloodBank->long = $request->get('long');
            $bloodBank->save();

            return response()->json(['status' => $status, 'data' => $bloodBank, 'message' => 'blood bank updated successfully']);
        }

        $bloodBank = new BloodBank([
            'uid' =>  $request->get('uid'),
            'name' =>  $request->get('name'),
            'about' =>  $request->get('about'),
            'address' =>  $request->get('address'),
            'phone' =>  $request->get('phone'),
            'email' =>  $request->get('email'),
            'token' =>  $request->get('token'),
            'lat' =>  $request->get('lat'),
            'long' =>  $request->get('long')
        ]);

        $bloodBank->save();

        return response()->json(['status' => $status, 'data' => $bloodBank, 'message' => 'blood bank added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param BloodBank $bloodBank
     * @return Response
     */
    public function show(BloodBank $bloodBank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BloodBank $bloodBank
     * @return Response
     */
    public function edit(BloodBank $bloodBank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param BloodBank $bloodBank
     * @return Response
     */
    public function update(Request $request, BloodBank $bloodBank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BloodBank $bloodBank
     * @return Response
     */
    public function destroy(BloodBank $bloodBank)
    {
        //
    }
}
