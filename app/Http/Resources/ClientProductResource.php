<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ClientProductResource extends JsonResource
{
    private function flattenImages()
    {
        $result = [];
        foreach ($this->images as $image) {
            $result[] = env("APP_URL") . Storage::url($image->file_path);
        }
        return $result;
    }

    private function flattenSizes()
    {
        $result = [];
        foreach ($this->sizes as $size) {
            $result[] = $size->title;
        }
        return $result;
    }

    private function flattenColors()
    {
        $result = [];
        foreach ($this->colors as $color) {
            $result[] = $color->code;
        }
        return $result;
    }

    private function flattenMaterials()
    {
        $result = [];
        foreach ($this->materials as $material) {
            $result[] = $material->title;
        }
        return $result;
    }

    private function flattenSeasons()
    {
        $result = [];
        foreach ($this->seasons as $season) {
            $result[] = $season->title;
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
            'hit' => $this->orders->count() > 10000,
            'new' => $this->created_at < now()->subMonths(6),
            'featured' => $this->featured ? true : false,
            'images' => $this->flattenImages(),
            'title' => $this->title,
            'description' => $this->description,
            'contents' => $this->contents,
            'price' => $this->price,
            'oldPrice' => $this->old_price,
            'numInStock' => $this->num_in_stock,
            'category' => $this->category->title,
            'subcategory' => $this->subcategory->title,
            'type' => $this->type->title,
            'manufacturer' => $this->manufacturer->name,
            'sizes' => $this->flattenSizes(),
            'colors' => $this->flattenColors(),
            'materials' => $this->flattenMaterials(),
            'seasons' => $this->flattenSeasons(),
        ];
    }
}
