<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    private function prepareProducts()
    {
        $products = [];
        foreach ($this->products as $product) {
            $product->quantity = $product->pivot->product_quantity;
            $products[] = $product;
        }
        return $products;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'shipping_address' => $this->shipping_address,
            'total' => $this->total,
            'status' => $this->status,
            'transaction_id' => $this->transaction_id,
            'created_at' => Carbon::parse($this->created_at)->format('m/d/Y H:i:s'),
            'user_id' => $this->user_id ?? '—',
            'products' => $this->prepareProducts(),
        ];
    }
}
