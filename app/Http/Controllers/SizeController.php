<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SizeController extends Controller
{
    public function index()
    {
        return Size::all();
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:sizes',
        ]);
        $size = new Size();
        $size->title = $validated["title"];
        $size->save();
    }

    public function show($id)
    {
        return Size::find($id);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sizes')->ignore($id)
            ],
        ]);
        $size = Size::find($id);
        $size->title = $validated["title"];
        $size->save();
    }

    public function delete($id)
    {
        Size::destroy($id);
    }
}
