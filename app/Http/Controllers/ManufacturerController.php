<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManufacturerController extends Controller
{

    public function index()
    {
        return Manufacturer::all();
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:manufacturers',
        ]);
        $manufacturer = new Manufacturer();
        $manufacturer->name = $validated["name"];
        $manufacturer->save();
    }

    public function show($id)
    {
        return Manufacturer::find($id);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('manufacturers')->ignore($id)
            ],
        ]);
        $manufacturer = Manufacturer::find($id);
        $manufacturer->name = $validated["name"];
        $manufacturer->save();
    }

    public function delete($id)
    {
        Manufacturer::destroy($id);
    }
}
