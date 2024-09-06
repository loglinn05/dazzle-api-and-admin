<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return Permission::all();
    }

    public function create(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255|unique:permissions'
        ]);

        Permission::create([
            'name' => $fields['name']
        ]);
    }

    public function show($id)
    {
        return Permission::find($id);
    }

    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions')->ignore($id)
            ]
        ]);

        Permission::find($id)->update([
            'name' => $fields['name']
        ]);
    }

    public function delete($id)
    {
        Permission::destroy($id);
    }
}
