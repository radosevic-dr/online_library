<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Sanctum\Sanctum;

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
            'picture' => ['file', 'max:5120'],
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

    public function viewUser(User $user)
    {

        if (auth()->user()->user_type !== User::USER_TYPE_LIBRARIAN) {
            return response()->json(['error' => 'Unauthorized'], 422);
        }

        return response()->json($user);
    }

    public function editUser(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'username' => ['sometimes', 'required', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['sometimes', 'required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'jmbg' => ['sometimes', 'required', 'min:13', 'max:13', 'regex:/^[0-9]+$/', Rule::unique('users', 'jmbg')->ignore($user->id)],
            'password' => ['sometimes', 'required', 'min:8', 'max:16'],
            'picture' => ['sometimes', 'file', 'max:5120', 'mimes:jpg,'],
        ]);

        if ($request->has('name') || $request->has('email') || $request->has('jmbg') || $request->has('password')) {
            $user->update($validatedData);
        }

        if ($request->hasFile('picture')) {
            $user->clearMediaCollection('profile_picture');
            $user->addMedia($request->file('picture'))->toMediaCollection('profile_picture');
        }

        return response()->json(['message' => 'User details updated successfully']);
    }

    public function delete(User $user)
    {
        $requestingUser = Auth::user();
        if ($requestingUser->user_type !== User::USER_TYPE_LIBRARIAN) {
            throw new UnauthorizedException("You don't have permission to delete user accounts");
        }

        $user->delete();

        return response()->json(['message' => 'User account deleted successfully']);
    }
}
