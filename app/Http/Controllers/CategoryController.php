<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function getSubcategories($id)
    {
        return Category::find($id)->subcategories;
    }

    public function getSizes($id)
    {
        return Category::find($id)->sizes;
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:categories',
        ]);
        $category = new Category();
        $category->title = $validated["title"];
        $category->save();
    }

    public function show($id)
    {
        return Category::find($id);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($id)
            ],
        ]);
        $category = Category::find($id);
        $category->title = $validated["title"];
        $category->save();
    }

    public function delete($id)
    {
        Category::destroy($id);
    }
}
