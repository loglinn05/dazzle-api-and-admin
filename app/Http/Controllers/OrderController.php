<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
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
}
