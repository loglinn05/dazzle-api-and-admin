<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use Carbon\Carbon;
use DB;

class RevenueController extends Controller
{
    public function getMonthlyRevenue()
    {
        $days = [];
        for ($i = 1; $i <= date("t"); $i++) {
            $days[] = $i;
        }

        $chartData = [
            "labels" => $days,
            "datasets" => [
                [
                    "label" => "Revenue",
                    "data" => [],
                    "fill" => false,
                    "borderColor" => "hotpink",
                    "tension" => 0.4
                ]
            ]
        ];

        for ($i = 0; $i < count($days); $i++) {
            $day = Carbon::createMidnightDate(null, null, $days[$i]);
            if ($day->gt(Carbon::today())) {
                break;
            }
            $daytotal = 0;
            foreach (Order::whereDate('created_at', $day->toDateString())->get() as $order) {
                $daytotal += $order->total;
            }
            $chartData["datasets"][0]["data"][] = $daytotal;
        }

        return $chartData;
    }

    public function getRevenueByCategories()
    {
        $categories = Category::all();

        $labels = [];
        $data = [];

        foreach ($categories as $category) {
            $labels[] = $category->title;
            $category_products = DB::table('orders')
                ->join('order_product', 'orders.id', '=', 'order_product.order_id')
                ->join('products', 'products.id', '=', 'order_product.product_id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select('products.price', 'order_product.product_quantity')
                ->where('categories.title', $category->title)
                ->get();
            $category_revenue = 0;
            foreach ($category_products as $category_product) {
                $category_revenue += $category_product->price * $category_product->product_quantity;
            }
            $data[] = $category_revenue;
        }

        $chartData = [
            "labels" => $labels,
            "datasets" => [
                [
                    "data" => $data,
                    "backgroundColor" => ["deeppink", "orange", "crimson"],
                    "hoverBackgroundColor" => ["#ff5ab3", "#fec04c", "#ef5171"],
                ]
            ]
        ];

        return $chartData;
    }
}
