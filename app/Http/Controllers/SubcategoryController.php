<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubcategoryResource;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubcategoryController extends Controller
{
    public function index()
    {
        return SubcategoryResource::collection(Subcategory::all());
    }

    public function getTypes($id)
    {
        return Subcategory::find($id)->types;
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:subcategories',
            'categoryId' => 'required|numeric',
        ]);

        $subcategory = new Subcategory();
        $subcategory->title = $validated["title"];

        $category = Category::find($validated["categoryId"]);
        $category->subcategories()->save($subcategory);
    }

    public function show($id)
    {
        return new SubcategoryResource(Subcategory::find($id));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('subcategories')->ignore($id)
            ],
        ]);
        $subcategory = Subcategory::find($id);
        $subcategory->title = $validated["title"];
        $subcategory->save();
    }

    public function delete($id)
    {
        Subcategory::destroy($id);
    }
}
