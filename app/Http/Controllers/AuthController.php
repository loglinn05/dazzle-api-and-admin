<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc|max:255|unique:users',
            'password' => 'required|string|max:255|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);

        $user->syncRoles(['customer']);

        $token = $user->createToken('dazzle_user_' . $fields['email'])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email:rfc|max:255',
            'password' => 'required|string|max:255'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Invalid credentials.'
            ], 401);
        }

        $token = $user->createToken('dazzle_user_' . $fields['email'])->plainTextToken;

        if ($request->from_customer)
            $response = [
                'user' => $user,
                'token' => $token
            ];
        else
            $response = [
                'user' => new UserResource($user),
                'token' => $token
            ];

        return response($response);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->noContent();
    }
}
