<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MaterialController extends Controller
{
    public function index()
    {
        return Material::all();
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:materials',
        ]);
        $material = new Material();
        $material->title = $validated["title"];
        $material->save();
    }

    public function show($id)
    {
        return Material::find($id);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('materials')->ignore($id)
            ],
        ]);
        $material = Material::find($id);
        $material->title = $validated["title"];
        $material->save();
    }

    public function delete($id)
    {
        Material::destroy($id);
    }
}
