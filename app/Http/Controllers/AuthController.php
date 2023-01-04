<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AuthAdminRequest;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|string|confirmed|max:16'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->assignRole('customer');
        $token = $user->createToken('first-ict')->plainTextToken;
        return response()->json([
            'data' => ['user' => $user, 'token' => $token],
            'errors' => [],
            'condition' => true

        ]);

    }
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {

            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('first-ict')->plainTextToken;

                return response()->json([
                    'data' => ['user'=>$user,'token'=> $token],
                    'errors' => [],
                    'condition' => true
                ]);

            } else {

                return $this->error('password credential error',403);
            }
        } else {

                return $this->error('there is no user with this email',403);
        }
        
        $token = $user->createToken('first-ict')->plainTextToken;
    }
}
