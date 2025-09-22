<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AdminProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = $this->whenLoaded('images');
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'number_in_stock' => $this->num_in_stock,
            'featured' => $this->featured ? true : false,
            'image' => $images->isNotEmpty() ? Storage::url($images->first()->file_path) : null,
            'category' => $this->whenLoaded('category')
        ];
    }
}
