<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $menu = [];
        foreach (Category::all() as $key => $category) {
            $menu[$key]['label'] = $category->title;
            if ($category->subcategories->count() > 0) {
                $menu[$key]['items'] = [];
                foreach ($category->subcategories as $subcategory) {
                    $menu[$key]['items'][] = [
                        'label' => $subcategory->title,
                        'route' => "/products?subcategory_id=$subcategory->id"
                    ];
                }
            }
        }
        return $menu;
    }
}
