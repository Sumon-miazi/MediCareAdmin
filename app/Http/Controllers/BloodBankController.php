<?php

namespace App\Http\Controllers;

use App\BloodBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class BloodBankController extends Controller
{

    public function getAllBloodBank()
    {
        $allBloodBank = BloodBank::where('approved', 1)->get();
        return response()->json(['status' => 'true', 'data' => $allBloodBank, 'message' => 'All blood bank']);
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
                        $bloodBank->image = 'blood-banks/' . $fileNameToStore;
                    }
                }
            }

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
                    $bloodBank->image = 'blood-banks/' . $fileNameToStore;
                }
            }
        }

        $bloodBank->save();

        return response()->json(['status' => $status, 'data' => $bloodBank, 'message' => 'blood bank added successfully']);
    }


    public function resizeImage($file, $fileNameToStore) {
      // Resize image
      $resize = Image::make($file)->resize(200, null, function ($constraint) {
        $constraint->aspectRatio();
      })->encode('jpg');

      $save = Storage::put("public/blood-banks/{$fileNameToStore}", $resize->__toString());

      if($save) {
        return true;
      }
      return false;
    }

}
