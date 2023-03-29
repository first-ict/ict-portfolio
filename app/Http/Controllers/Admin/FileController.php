<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends BaseController
{
    public function store(Request $request)
    {
        // return "hello world";
        $filename = time() . "_" . $request->file('file')->getClientOriginalName();
        $filename = request()->file('file')->storeAs('photos', $filename);
        $file = new File();
        $file->file = $filename;
        $file->save();
        return $this->response("File created successfully",$file);
    }
}
