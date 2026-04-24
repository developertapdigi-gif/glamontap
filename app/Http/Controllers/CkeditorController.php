<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Validator;

class CkeditorController extends Controller
{
    public function upload(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'upload'=>['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:5120'],
        ]);
        if ($validator->fails()) {
            return response()->json([                          
                'error'      =>[
                    'message'=>$validator->errors()->first()
                ],
            ]);
        }
        if($request->hasFile('upload')) {
            $folderPath = $this->getPath();              
            $extension = $request->file('upload')->getClientOriginalExtension();           
            $fileName = $folderPath.'/'.uniqid().'.'.$extension;
            $request->file('upload')->move(public_path($folderPath), $fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset($fileName); 
            $msg = 'Image successfully uploaded'; 
            return response()->json([
                'fileName' => $fileName,
                'uploaded' => 1,
                'url'      => $url,
            ]);
        }
    }  

    private function getPath(){
        $year = date('Y');
        $month = date('m');
        File::ensureDirectoryExists("uploads/$year/$month");
        return "uploads/$year/$month";
    }
}
