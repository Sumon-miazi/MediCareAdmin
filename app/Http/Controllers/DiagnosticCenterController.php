<?php

namespace App\Http\Controllers;

use App\DiagnosticCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class DiagnosticCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diagnostic = DiagnosticCenter::where("approved", 1)->get();
        return response()->json(['status' => 'true', 'data' => $diagnostic, 'message' => 'all diagnostic center return']);
    }


    public function getDiagnosticCenterDataByUid(Request $request){
        $status = false;
        $validator = Validator()->make($request->all(), [
            'uid' => 'required'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        if (DiagnosticCenter::where('uid', $request->uid)->exists()) {
            $dc = DiagnosticCenter::where("uid", $request->uid)->first();
            $status = true;
            return response()->json(['status' => $status, 'data' => $dc, 'message' => 'diagnostic center found']);
        } else {
            $status = false;
            return response()->json(['status' => $status, 'data' => null, 'message' => 'user not found']);
        }
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
        $status = false;
        $validator = Validator()->make($request->all(), [
            'name'=>'required',
            'address'=>'required',
            'services'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'lat'=>'required',
            'long'=>'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        $status = true;

        if (DiagnosticCenter::where('uid', $request->uid)->exists()) {
            $diagnosticCenter = DiagnosticCenter::where("uid", $request->uid)->first();
            $diagnosticCenter->name = $request->get('name');
            $diagnosticCenter->services = $request->get('services');
            $diagnosticCenter->address = $request->get('address');
            $diagnosticCenter->phone = $request->get('phone');
            $diagnosticCenter->email = $request->get('email');
            $diagnosticCenter->token = $request->get('token');
            $diagnosticCenter->lat = $request->get('lat');
            $diagnosticCenter->long = $request->get('long');

            $url = null;

            if ($request->hasFile('image')) {
                //  Let's do everything here
                if ($request->file('image')->isValid()) {
                    //
                    $validated = $request->validate([
                        'image' => 'mimes:jpeg,png',
                    ]);
                    $extension = $request->image->extension();
                    $request->image->storeAs('/public/diagnostic', $request->get('uid').".".$extension);
                    $url = Storage::url($request->get('uid').".".$extension);
                }
            }
            $diagnosticCenter->image = $url;
            $diagnosticCenter->save();

            return response()->json(['status' => $status, 'data' => $diagnosticCenter, 'message' => 'diagnostic center updated successfully']);
        }

        $diagnosticCenter = new DiagnosticCenter([
            'uid' =>  $request->get('uid'),
            'name' =>  $request->get('name'),
            'services' =>  $request->get('services'),
            'address' =>  $request->get('address'),
            'phone' =>  $request->get('phone'),
            'email' =>  $request->get('email'),
            'token' =>  $request->get('token'),
            'lat' =>  $request->get('lat'),
            'long' =>  $request->get('long')
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
                $request->image->storeAs('/public/diagnostic', $request->get('uid').".".$extension);
                $url = Storage::url($request->get('uid').".".$extension);
            }
        }
        $diagnosticCenter->image = $url;
        $diagnosticCenter->save();

        return response()->json(['status' => $status, 'data' => $diagnosticCenter, 'message' => 'diagnostic center added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DiagnosticCenter  $diagnosticCenter
     * @return \Illuminate\Http\Response
     */
    public function show(DiagnosticCenter $diagnosticCenter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DiagnosticCenter  $diagnosticCenter
     * @return \Illuminate\Http\Response
     */
    public function edit(DiagnosticCenter $diagnosticCenter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DiagnosticCenter  $diagnosticCenter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DiagnosticCenter $diagnosticCenter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DiagnosticCenter  $diagnosticCenter
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiagnosticCenter $diagnosticCenter)
    {
        //
    }
}
