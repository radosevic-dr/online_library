<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    
    public function login(Request $request)
    {
        try {
            $validateLogin = Validator::make($request->all(),
                [
                    'email' => ['required', 'email'],
                    'password' => ['required', 'min:8', 'max:32'],
                ]
            );

            if ($validateLogin->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validateLogin->errors(),
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            if($user){
                session_start();
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
            
                $apiToken = $user->createToken('API TOKEN')->plainTextToken;

                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully Logged In',
                    'token' => $apiToken
                ], 200);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'false',
                'message' => $th->getMessage(),
            ], 500);
        }

    }
}
