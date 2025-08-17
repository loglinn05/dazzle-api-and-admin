<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Manufacturer;
use App\Models\Material;
use App\Models\Product;
use App\Models\Season;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function getFilterList(Request $request)
    {
        $filterList = [];
        $filterList['types'] = Subcategory::find($request->subcategory_id)
            ->types()->withCount([
                    'products' => function ($query) {
                        $query->withFilters();
                    }
                ])
            ->get();
        $filterList['sizes'] = Subcategory::find($request->subcategory_id)->
            category->sizes()->withCount([
                    'products' => function ($query) {
                        $query->withFilters();
                    }
                ])
            ->get();
        $filterList['price']['min'] = Product::where('subcategory_id', $request->subcategory_id)->min('price');
        $filterList['price']['selectedMin'] = Product::where('subcategory_id', $request->subcategory_id)->withFilters()->min('price');
        $filterList['price']['max'] = Product::where('subcategory_id', $request->subcategory_id)->max('price');
        $filterList['price']['selectedMax'] = Product::where('subcategory_id', $request->subcategory_id)->withFilters()->max('price');
        $filterList['manufacturers'] = Manufacturer::withCount([
            'products' => function ($query) {
                $query->withFilters();
            }
        ])
            ->get();
        $filterList['colors'] = Color::withCount([
            'products' => function ($query) {
                $query->withFilters();
            }
        ])
            ->get();
        $filterList['materials'] = Material::withCount([
            'products' => function ($query) {
                $query->withFilters();
            }
        ])
            ->get();
        $filterList['seasons'] = Season::withCount([
            'products' => function ($query) {
                $query->withFilters();
            }
        ])
            ->get();
        return $filterList;
    }
}
