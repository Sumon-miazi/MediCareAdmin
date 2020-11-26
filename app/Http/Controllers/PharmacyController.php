<?php

namespace App\Http\Controllers;

use App\Pharmacy;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
     public function getAllPharmacies()
    {
        $pharmacies = Pharmacy::where('approved', 1)->get();
        return response()->json(['status' => 'true', 'data' => $pharmacies, 'message' => 'All pharmacies return']);
    }

    public function getPharmacyDataByUid(Request $request){
        $status = false;
        $validator = Validator()->make($request->all(), [
            'uid' => 'required'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return response()->json(['status' => $status, 'message' => $message]);
        }

        if (Pharmacy::where('uid', $request->uid)->exists()) {
            $pharmacy = Pharmacy::where("uid", $request->uid)->first();
            $status = true;
            return response()->json(['status' => $status, 'data' => $pharmacy, 'message' => 'Pharmacyfound']);
        } else {
            $status = false;
            return response()->json(['status' => $status, 'data' => null, 'message' => 'user not found']);
        }
    }

    public function store(Request $request)
    {
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

        if (Pharmacy::where('uid', $request->uid)->exists()) {
            $pharmacy = Pharmacy::where("uid", $request->uid)->first();
            $pharmacy->name = $request->get('name');
            $pharmacy->about = $request->get('about');
            $pharmacy->address = $request->get('address');
            $pharmacy->phone = $request->get('phone');
            $pharmacy->email = $request->get('email');
            $pharmacy->token = $request->get('token');
            $pharmacy->lat = $request->get('lat');
            $pharmacy->long = $request->get('long');

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

                   // $request->image->storeAs('/public/patients', $fileNameToStore);
                    if($save){
                        $pharmacy->image = 'pharmacies/' . $fileNameToStore;
                    }
                }
            }

            $pharmacy->save();

            return response()->json(['status' => $status, 'data' => $pharmacy, 'message' => 'pharmacy updated successfully']);
        }

        $pharmacy = new Pharmacy([
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
                    $pharmacy->image = 'pharmacies/' . $fileNameToStore;
                }
            }
        }

        $pharmacy->save();

        return response()->json(['status' => $status, 'data' => $pharmacy, 'message' => 'pharmacy added successfully']);
    }


    public function resizeImage($file, $fileNameToStore) {
      // Resize image
      $resize = Image::make($file)->resize(200, null, function ($constraint) {
        $constraint->aspectRatio();
      })->encode('jpg');

      $save = Storage::put("public/pharmacies/{$fileNameToStore}", $resize->__toString());

      if($save) {
        return true;
      }
      return false;
    }
}
