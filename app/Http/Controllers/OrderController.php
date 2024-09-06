<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $data = json_decode($request->orderData, true);

        $fields = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email:rfc',
            'shippingAddress' => 'required|string',
            'productIds' => 'required|array',
            'productIds.*' => 'required',
            'productIds.*.id' => 'required|integer',
            'productIds.*.quantity' => 'required|integer',
            'total' => 'required|integer',
            'paymentMethod' => 'required|string',
        ])->validate();

        $order = Order::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'shipping_address' => $fields['shippingAddress'],
            'total' => $fields['total'] / 100,
            'status' => 'pending',
        ]);

        foreach ($fields['productIds'] as $productId) {
            $order->products()->attach(
                $productId['id'],
                ['product_quantity' => $productId['quantity']]
            );
            Product::find($productId['id']);
        }

        $payment = (new User)->charge(
            $fields['total'],
            $fields['paymentMethod'],
            ['return_url' => 'http://localhost:5173']
        );

        if ($payment->id) {
            $order->status = 'paid';
            $order->transaction_id = $payment->id;
            $order->save();

            return response()->json([
                'transaction_id' => $payment->id,
                'total' => $order->total
            ], 200);
        }
    }

    public function index()
    {
        return Order::all();
    }

    public function show($id)
    {
        return new OrderResource(Order::find($id));
    }

    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email:rfc',
                Rule::unique('orders')->ignore($id)
            ],
            'shipping_address' => 'required|string|max:255',
            'total' => 'required|numeric',
            'status' => [
                'required',
                Rule::in(['pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled', 'returned'])
            ],
            'user_id' => 'integer|nullable',
        ]);

        $order = Order::find($id);
        $order->name = $fields['name'];
        $order->email = $fields['email'];
        $order->shipping_address = $fields['shipping_address'];
        $order->total = $fields['total'];
        $order->status = $fields['status'];
        $order->user()->associate(User::find($fields['user_id']));
        $order->save();
    }

    public function getRecentOrders()
    {
        return OrderResource::collection(
            Order::orderByDesc('created_at')
                ->limit(5)
                ->get()
        );
    }
}
