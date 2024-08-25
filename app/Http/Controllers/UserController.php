<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function assignRoles(Request $request, $id)
    {
        $fields = $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'required|string',
        ]);

        User::find($id)->syncRoles($fields['roles']);
    }

    public function create(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email:rfc|unique:users',
            'password' => 'required|string|min:8|max:255|confirmed',
            'roles' => 'nullable|array',
            'roles.*' => 'required|string'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
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
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email:rfc',
                Rule::unique('users')->ignore($id)
            ],
            'new_password' => 'string|min:8|max:255|confirmed|nullable',
            'roles' => 'array|nullable',
            'roles.*' => 'string',
        ]);

        $user = User::find($id);
        $user->name = $fields['name'];
        $user->email = $fields['email'];
        if (isset($fields['new_password']) && $fields['new_password']) {
            $user->password = $fields['new_password'];
        }
        $user->save();
        if (isset($fields['roles'])) {
            $user->syncRoles($fields['roles']);
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $fields = $request->validate([
            'new_password' => 'required|string|max:255|confirmed'
        ]);

        User::find($id)->update([
            'password' => $fields['new_password'],
        ]);
    }

    public function delete($id)
    {
        User::destroy($id);
    }
}
