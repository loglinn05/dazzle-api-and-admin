<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Manufacturer;
use App\Models\Material;
use App\Models\Product;
use App\Models\Season;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\Type;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function getFilterList($subcategory_id)
    {
        $filterList = [
            'types' => [],
            'sizes' => [],
            'price' => [
                'min' => 0,
                'max' => 0
            ]
        ];
        $filterList['types'] = Subcategory::find($subcategory_id)
            ->types()->withCount([
                    'products' => function ($query) {
                        $query->withFilters();
                    }
                ])
            ->get();
        $filterList['sizes'] = Subcategory::find($subcategory_id)->
            category->sizes()->withCount([
                    'products' => function ($query) {
                        $query->withFilters();
                    }
                ])
            ->get();
        $filterList['price']['min'] = Product::withFilters()->min('price') ?
            Product::withFilters()->min('price') :
            Product::all()->min('price');
        $filterList['price']['max'] = Product::withFilters()->max('price') ?
            Product::withFilters()->max('price') :
            Product::all()->max('price');
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
