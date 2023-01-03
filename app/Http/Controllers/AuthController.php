<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AuthAdminRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;


class AuthController extends BaseController
{
    public function register(AuthAdminRequest $request)
    {
        $request->validated();

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
    public function login(AuthAdminRequest $request)
    {

        $request->validated();

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('first-ict')->plainTextToken;
                return response()->json([
                    'data' => ['user' => $user, 'token' => $token],
                    'errors' => [],
                    'condition' => true
                ]);
            } else {
                return response()->json([
                    'data' => [],
                    'errors' => ['message' => 'password credential error'],
                    'condition' => false

                ], 403);
            }
        } else {
            return response()->json([
                'data' => [],
                'errors' => ['message' => 'there is no user with this email'],
                'condition' => false

            ], 403);
        }
        $token = $user->createToken('first-ict')->plainTextToken;
    }
}
