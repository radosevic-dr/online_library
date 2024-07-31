<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;

class UserController extends Controller
{
    public function login(Request $request)
    {

        $validateLogin = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'max:32'],
        ]);

        if (auth()->attempt($validateLogin)) {
            $user = User::where('email', $validateLogin['email'])->first();
            $token = $user->createToken('API TOKEN')->plainTextToken;

            return $token;
        } else {
            return response()->json(['error' => 'Invalid credentials'], 422);
        }
    }

    public function logout(Request $request)
    {
        if ($token = $request->bearerToken()) {
            $model = Sanctum::$personalAccessTokenModel;
            $accessToken = $model::findToken($token);
            $accessToken->delete();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User Logged out',
        ], 200);
    }
}
