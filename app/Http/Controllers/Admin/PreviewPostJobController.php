<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PreviewPostJobController extends Controller
{
    public function preview(Request $request){
        $data = $request->session()->all();
        return view('admin.job.preview')->with('data',$data);
    }
}
