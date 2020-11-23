<?php

namespace App\Http\Controllers;

use App\DiagnosticCenter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Image;

class DiagnosticCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
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
            'name' => 'required',
            'address' => 'required',
            'services' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
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
            $diagnosticCenter->latitude = $request->get('lat');
            $diagnosticCenter->longitude = $request->get('long');

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
                        $diagnosticCenter->image = 'diagnostic-centers/' . $fileNameToStore;
                    }
                }
            }

            $diagnosticCenter->save();

            return response()->json(['status' => $status, 'data' => $diagnosticCenter, 'message' => 'diagnostic center updated successfully']);
        }

        $diagnosticCenter = new DiagnosticCenter([
            'uid' => $request->get('uid'),
            'name' => $request->get('name'),
            'services' => $request->get('services'),
            'address' => $request->get('address'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'token' => $request->get('token'),
            'latitude' => $request->get('lat'),
            'longitude' => $request->get('long')
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
                    $diagnosticCenter->image = 'diagnostic-centers/' . $fileNameToStore;
                }
            }
        }

        $diagnosticCenter->save();

        return response()->json(['status' => $status, 'data' => $diagnosticCenter, 'message' => 'diagnostic center added successfully']);
    }

    public function resizeImage($file, $fileNameToStore) {
      // Resize image
      $resize = Image::make($file)->resize(200, null, function ($constraint) {
        $constraint->aspectRatio();
      })->encode('jpg');

      $save = Storage::put("public/diagnostic-centers/{$fileNameToStore}", $resize->__toString());

      if($save) {
        return true;
      }
      return false;
    }

    /**
     * Display the specified resource.
     *
     * @param DiagnosticCenter $diagnosticCenter
     * @return Response
     */
    public function show(DiagnosticCenter $diagnosticCenter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DiagnosticCenter $diagnosticCenter
     * @return Response
     */
    public function edit(DiagnosticCenter $diagnosticCenter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param DiagnosticCenter $diagnosticCenter
     * @return Response
     */
    public function update(Request $request, DiagnosticCenter $diagnosticCenter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DiagnosticCenter $diagnosticCenter
     * @return Response
     */
    public function destroy(DiagnosticCenter $diagnosticCenter)
    {
        //
    }
}
