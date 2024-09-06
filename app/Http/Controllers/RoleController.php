<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Role;
use Validator;

class RoleController extends Controller
{
    public function index()
    {
        return RoleResource::collection(Role::all());
    }

    public function create(Request $request)
    {
        $data = json_decode($request->roleData, true);
        $rules = [
            'name' => 'required|string|max:255|unique:roles',
            'permissions' => 'array|nullable',
            'permissions.*' => 'string',
        ];
        $fields = Validator::make($data, $rules)->validate();

        $role = Role::create([
            'name' => $fields['name']
        ]);
        if (isset($fields['permissions'])) {
            $role->syncPermissions($fields['permissions']);
        }
    }

    public function show($id)
    {
        return new RoleResource(Role::find($id));
    }

    public function update(Request $request, $id)
    {
        $data = json_decode($request->roleData, true);
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->ignore($id)
            ],
            'permissions' => 'array|nullable',
            'permissions.*' => 'string',
        ];
        $fields = Validator::make($data, $rules)->validate();

        $role = Role::findOrFail($id);
        $role->update([
            'name' => $fields['name']
        ]);
        if (isset($fields['permissions'])) {
            $role->syncPermissions($fields['permissions']);
        }
    }

    public function delete($id)
    {
        Role::destroy($id);
    }
}
