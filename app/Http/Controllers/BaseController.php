<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function success($data, $message = '')
    {
        return $data->additional(['condition'=> true, 'message' => $message] );
    }
    public function error($errors = [], $code = 422, $message = '')
    {
        return $this->response($message,[], $errors, $code, false);
    }
    public function validateError($errors = [])
    {
        return $this->response("Validation Error",[], $errors, 422, false);
    }
    public function response($message = '', $data,$errors = null, $code=200,$condition=true)
    {
        return response()->json([
            'data'=>$data,
            'message'=>$message,
            'errors' => $errors,
            'code' => $code,
            'condition' => $condition,
        ],$code);
    }
    public function validator($data=[])
    {
        $validator = Validator::make($data, [
            'name' => 'required',
            'paragraph' => 'required'
        ]);
        return $validator;
    }
}
