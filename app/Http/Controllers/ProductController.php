<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\AdminProductResource;
use App\Http\Resources\ClientProductResource;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Subcategory;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        return AdminProductResource::collection(Product::all());
    }

    public function getProducts(Request $request, $subcategory_id = null)
    {
        if ($subcategory_id != null && is_integer((int)$subcategory_id)) {
            return ClientProductResource::collection(Product::where('subcategory_id', $subcategory_id)->withFilters()->get());
        } else {
            if (is_bool($request->new) && $request->new) {
                return ClientProductResource::collection(Product::where('created_at', '>=', Carbon::now()->subMonth())->orderByDesc('created_at')->limit(8)->get());
            }
            if (is_bool($request->featured) && $request->featured) {
                return ClientProductResource::collection(Product::where('featured', true)->orderByDesc('created_at')->limit(8)->get());
            }
            return ClientProductResource::collection(Product::where('subcategory_id', 2)->get());
        }
    }

    public function getProduct(Request $request)
    {
        if (is_integer((int)$request->product_id)) {
            return new ClientProductResource(Product::find($request->product_id));
        } else {
            abort(400, 'Invalid product ID');
        }
    }

    private function buildAndSaveProduct(Product $product, Request $request)
    {
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
            // $filePath = Storage::disk('public')->putFileAs('product_images', $image, $fileName);
            $filePath = Storage::putFileAs("product_images", $image, $fileName);
            $productImage->file_name = $fileName;
            $productImage->file_path = $filePath;
            $product->images()->save($productImage);
        }
    }

    public function create(ProductRequest $request)
    {
        $product = new Product();

        $this->buildAndSaveProduct($product, $request);
    }

    public function show($id)
    {
        return new AdminProductResource(Product::find($id));
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);

        $product->sizes()->detach();

        $product->colors()->detach();

        $product->materials()->detach();

        $product->seasons()->detach();

        foreach ($product->images as $image) {
            Storage::delete($image->file_path);
        }

        $product->images()->delete();

        $this->buildAndSaveProduct($product, $request);
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
