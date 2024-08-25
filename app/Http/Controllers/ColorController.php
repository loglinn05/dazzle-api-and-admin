<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ColorController extends Controller
{
    public function index()
    {
        return Color::all();
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|hex_color|unique:colors',
        ]);
        $color = new Color();
        $color->code = $validated["code"];
        $color->save();
    }

    public function show($id)
    {
        return Color::find($id);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'hex_color',
                Rule::unique('colors')->ignore($id)
            ],
        ]);
        $color = Color::find($id);
        $color->code = $validated["code"];
        $color->save();
    }

    public function delete($id)
    {
        Color::destroy($id);
    }
}
