<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function create(Request $request)
    {
        $data = json_decode($request->userData, true);

        $fields = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email:rfc|unique:users',
            'password' => 'required|string|min:8|max:255|confirmed',
            'roles' => 'nullable|array',
            'roles.*' => 'required|string'
        ])->validate();

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);

        if (isset($fields['roles'])) {
            $user->syncRoles($fields['roles']);
        }
    }

    public function show($id)
    {
        return new UserResource(User::find($id));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email:rfc',
                Rule::unique('users')->ignore($id)
            ],
            'roles' => 'array|nullable',
            'roles.*' => 'string',
        ];
        if (isset($request->new_password) && $request->new_password) {
            $rules['new_password'] = 'string|min:8|max:255|confirmed';
        }
        $data = json_decode($request->userData, true);
        $fields = Validator::make($data, $rules)->validate();

        $user = User::find($id);
        $user->name = $fields['name'];
        $user->email = $fields['email'];
        if (isset($fields['new_password']) && $fields['new_password']) {
            $user->password = Hash::make($fields['new_password']);
        }
        $user->save();
        if (isset($fields['roles'])) {
            $user->syncRoles($fields['roles']);
        }
        return $fields;
    }

    public function updateProfile(Request $request)
    {
        $fields = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $request->user()->id,
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::find($request->user()->id);

        if (isset($fields['name']))
            $user->name = $fields['name'];

        if (isset($fields['email'])) {
            $user->email = $fields['email'];
        }

        $passwordMatches = true;
        try {
            $passwordMatches = isset($fields['new_password']) &&
                Hash::check($fields['new_password'], $user->password);
        } catch (\Exception $e) {
            $passwordMatches = false;
        }

        if (isset($fields['new_password']) && !$passwordMatches) {
            $user->password = Hash::make($fields['new_password']);
        }

        if ($user->isDirty())
            $user->save();

        $logout = false;
        if ($user->wasChanged('email') || $user->wasChanged('password')) {
            $logout = true;
            auth('sanctum')->user()->tokens()->delete();
        }

        return ['success' => true, 'changed' => $logout ? [] : $user->getChanges(), 'logout' => $logout];
    }

    public function updatePassword(Request $request, $id)
    {
        $fields = $request->validate([
            'new_password' => 'required|string|max:255|confirmed'
        ]);

        User::find($id)->update([
            'password' => Hash::make($fields['new_password']),
        ]);
    }

    public function delete($id)
    {
        User::destroy($id);
    }
}
