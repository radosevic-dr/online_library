<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $validateNewUser = $request->validate([
            'name' => ['required'],
            'username' => ['required', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'jmbg' => ['required', 'min:13', 'max:13', Rule::unique('users', 'jmbg'), 'regex:/^[0-9]+$/'],
            'password' => ['required', 'min:8', 'max:16'],
            'user_type' => ['required', Rule::in([User::USER_TYPE_LIBRARIAN, User::USER_TYPE_STUDENT])],
            'picture' => ['file', 'max:5120']
        ]);
        
        $user = User::create($validateNewUser);

        if ($request->hasFile('picture')) {
            $user->addMedia($request->file('picture'))->toMediaCollection('profile_picture');
        }
    

        return $user;
    }
    
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
