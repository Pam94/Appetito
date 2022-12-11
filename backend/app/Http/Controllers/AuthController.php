<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {

            $validateLogin = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateLogin->fails()) {

                return response()->json([
                    'message' => 'Invalid Login parameters',
                    'errors' => $validateLogin->errors()
                ], 401);
            }

            if (Auth::attempt($request->only('email', 'password'))) {

                $user = User::where('email', $request->email)->first();

                return response()->json([
                    'token' => $user->createToken("API TOKEN")->plainTextToken,
                    'message' => 'User Logged In Successfully'
                ], 200);
            }

            return response()->json([
                'message' => 'Email and password are invalid'
            ], 401);
        } catch (\Throwable $throwable) {

            return response()->json([
                'message' => $throwable->getMessage()
            ], 500);
        }
    }

    public function register(Request $request)
    {

        try {

            $validateRegister = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'surname' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required'
                ]
            );

            if ($validateRegister->fails()) {

                return response()->json([
                    'message' => 'Invalid Register parameters',
                    'errors' => $validateRegister->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'message' => 'User Created Successfully'
            ], 200);
        } catch (\Throwable $throwable) {

            return response()->json([
                'message' => $throwable->getMessage()
            ], 500);
        }
    }
}
