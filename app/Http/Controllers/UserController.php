<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
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
            $user->password = $fields['new_password'];
        }
        $user->save();
        if (isset($fields['roles'])) {
            $user->syncRoles($fields['roles']);
        }
        return $fields;
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
