<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends BaseController
{
    public function index()
    {
        return $this->response('fetched all photos' , File::all());
    }
    public function  show($file){
       $file =  File::where('id', $file)->first();
       return $this->response("File",$file->file);
    }
    public function index()
    {
        return $this->response("all photos", File::all());
    }
    public function store(Request $request)
    {
        $filename = time() . "_" . $request->file('file')->getClientOriginalName();
        $filename = request()->file('file')->storeAs('photos', $filename);
        $file = new File();
        $file->file = $filename;
        $file->save();
        return $this->response("File created successfully",$file);
    }
}
