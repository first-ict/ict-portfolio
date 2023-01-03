<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
{
    public function success ($data)
    {
        return $data->additional(['condition'=> true]);
    }

    public function error($errors=[],$code=404)
    {
        return $this->response([],$errors,$code,false);
    }

    public function response($data, $errors , $code=200,$condition=true)
    {
        return response()->json([
            "data"=>$data,
            "errors"=>$errors,
            "condition"=>$condition,
        ],$code);
    }


    public function validator($data=[])
    {

        $confirm = Validator::make($data, [
             'image' => 'required',
             'order_by' => 'required',
             'status' => 'required',
        ]);

        return $confirm;

    }

    
}
