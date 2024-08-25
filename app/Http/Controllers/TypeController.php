<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypeResource;
use App\Models\Subcategory;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TypeController extends Controller
{
    public function index()
    {
        return TypeResource::collection(Type::all());
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subcategoryId' => 'required|numeric',
        ]);

        $type = new Type();
        $type->title = $validated["title"];

        $subcategory = Subcategory::find($validated["subcategoryId"]);
        $subcategory->types()->save($type);
    }

    public function show($id)
    {
        return new TypeResource(Type::find($id));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $type = Type::find($id);
        $type->title = $validated["title"];
        $type->save();
    }

    public function delete($id)
    {
        Type::destroy($id);
    }
}
