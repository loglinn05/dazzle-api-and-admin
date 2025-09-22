<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AdminProductResource extends JsonResource
{
    private function prepareImages($images)
    {
        $result = [];
        foreach ($images as $image) {
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
        $sizes = $this->whenLoaded('sizes');
        $seasons = $this->whenLoaded('seasons');
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'contents' => $this->contents,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'number_in_stock' => $this->num_in_stock,
            'featured' => $this->featured ? true : false,
            'images' => $this->whenLoaded('images', function () {
                $result = [];
                foreach ($this->images as $image) {
                    $image->file_path = Storage::url($image->file_path);
                    $result[] = $image;
                }
                return $result;
            }),
            'created_at' => Carbon::parse($this->created_at)->format('m/d/Y H:i:s'),
            'category' => $this->whenLoaded('category'),
            'subcategory' => $this->whenLoaded('subcategory'),
            'type' => $this->whenLoaded('type'),
            'manufacturer' => $this->whenLoaded('manufacturer'),
            'sizes' => $this->when(count($sizes) > 0, $sizes),
            'colors' => $this->whenLoaded('colors'),
            'materials' => $this->whenLoaded('materials'),
            'seasons' => $this->when(count($seasons) > 0, $seasons),
        ];
    }
}
