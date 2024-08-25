<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\AdminProductResource;
use App\Http\Resources\ClientProductResource;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Subcategory;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return AdminProductResource::collection(Product::all());
    }

    public function getProducts(Request $request)
    {
        if (is_integer((int) $request->subcategory_id)) {
            return ClientProductResource::collection(Product::where('subcategory_id', $request->subcategory_id)->get());
        } else {
            return ClientProductResource::collection(Product::where('subcategory_id', 2)->get());
        }
    }

    public function create(ProductRequest $request)
    {
        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->contents = $request->contents;
        $product->price = $request->price;
        $product->old_price = $request->old_price;
        $product->num_in_stock = $request->number_in_stock;
        $product->featured = $request->featured;

        $category = Category::find($request->category);
        $product->category()->associate($category);

        $subcategory = Subcategory::find($request->subcategory);
        $product->subcategory()->associate($subcategory);

        $type = Type::find($request->type);
        $product->type()->associate($type);

        $manufacturer = Manufacturer::find($request->manufacturer);
        $product->manufacturer()->associate($manufacturer);

        $product->save();

        $product->sizes()->attach($request->sizes);
        $product->colors()->attach($request->colors);
        $product->materials()->attach($request->materials);
        $product->seasons()->attach($request->seasons);

        foreach ($request->file("images") as $image) {
            $productImage = new ProductImage();
            $fileName = time() . '_' . $image->getClientOriginalName();
            $filePath = Storage::disk('public')->putFileAs('product_images', $image, $fileName);
            $productImage->file_name = $fileName;
            $productImage->file_path = $filePath;
            $product->images()->save($productImage);
        }
    }

    public function show($id)
    {
        return new AdminProductResource(Product::find($id));
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);
        $product->title = $request->title;
        $product->description = $request->description;
        $product->contents = $request->contents;
        $product->price = $request->price;
        $product->old_price = $request->old_price;
        $product->num_in_stock = $request->number_in_stock;
        $product->featured = $request->featured;

        $category = Category::find($request->category);
        $product->category()->associate($category);

        $subcategory = Subcategory::find($request->subcategory);
        $product->subcategory()->associate($subcategory);

        $type = Type::find($request->type);
        $product->type()->associate($type);

        $manufacturer = Manufacturer::find($request->manufacturer);
        $product->manufacturer()->associate($manufacturer);

        $product->save();

        $product->sizes()->detach();
        $product->sizes()->attach($request->sizes);

        $product->colors()->detach();
        $product->colors()->attach($request->colors);

        $product->materials()->detach();
        $product->materials()->attach($request->materials);

        $product->seasons()->detach();
        $product->seasons()->attach($request->seasons);

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->file_path);
        }

        $product->images()->delete();

        foreach ($request->file("images") as $image) {
            $productImage = new ProductImage();
            $fileName = time() . '_' . $image->getClientOriginalName();
            $filePath = Storage::disk('public')->putFileAs('product_images', $image, $fileName);
            $productImage->file_name = $fileName;
            $productImage->file_path = $filePath;
            $product->images()->save($productImage);
        }
    }

    public function delete($id)
    {
        $product = Product::find($id);

        $product->sizes()->detach();
        $product->colors()->detach();
        $product->materials()->detach();
        $product->seasons()->detach();

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->file_path);
        }

        $product->images()->delete();

        $product->delete();
    }
}
