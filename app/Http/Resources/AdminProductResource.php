<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use Illuminate\Support\Facades\Storage;

class AdminProductResource extends JsonResource
{
    private function prepareImages()
    {
        $result = [];
        foreach ($this->images as $image) {
            $image->file_path = Storage::url($image->file_path);
            $result[] = $image;
        }
        return $result;
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
            'title' => $this->title,
            'description' => $this->description,
            'contents' => $this->contents,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'number_in_stock' => $this->num_in_stock,
            'featured' => $this->featured ? true : false,
            'images' => $this->prepareImages(),
            'created_at' => Carbon::parse($this->created_at)->format('m/d/Y H:i:s'),
            'category' => $this->category,
            'subcategory' => $this->subcategory,
            'type' => $this->type,
            'manufacturer' => $this->manufacturer,
            'sizes' => $this->when(count($this->sizes) > 0, $this->sizes),
            'colors' => $this->colors,
            'materials' => $this->materials,
            'seasons' => $this->when(count($this->seasons) > 0, $this->seasons),
        ];
    }
}
