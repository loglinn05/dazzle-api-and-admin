<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
{
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
            'subcategory_id' => $this->subcategory->id,
            'subcategory_title' => $this->subcategory->title,
            'category_id' => $this->subcategory->category->id,
            'category_title' => $this->subcategory->category->title,
        ];
    }
}
