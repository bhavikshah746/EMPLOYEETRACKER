<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function storeImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file'=>'mimes:jpeg,bmp,png,gif'
        ]);
        if ($request->hasFile('file') && !$validator->fails())
        {
            $file = $request->file('file');
            $destinationPath = public_path().'/uploads/image/'.date('d-m-Y');

            $filename = time().'-'.$file->getClientOriginalName();

            $upload_success = $file->move($destinationPath, $filename);
            $data['image'] = $filename;
            $data['image_path']='uploads/image/'.date('d-m-Y');
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }
        return $data;
    }
}
