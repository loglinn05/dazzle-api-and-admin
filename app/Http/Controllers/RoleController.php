<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return Role::all();
    }

    public function create(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255|unique:roles'
        ]);

        Role::create([
            'name' => $fields['name']
        ]);
    }

    public function show($id)
    {
        return Role::find($id);
    }

    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->ignore($id)
            ]
        ]);

        Role::find($id)->update([
            'name' => $fields['name']
        ]);
    }

    public function delete($id)
    {
        Role::destroy($id);
    }

    public function givePermissions(Request $request, $id)
    {
        $fields = $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'required|string',
        ]);

        $role = Role::findOrFail($id);
        $role->syncPermissions($fields['permissions']);
    }
}
