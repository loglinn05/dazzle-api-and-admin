<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => "required|string|max:255",
            "description" => "required|string",
            "contents" => "required|string",
            "price" => "required|numeric",
            "old_price" => "required|numeric",
            "number_in_stock" => "required|integer",
            "featured" => "required|boolean",
            "images" => "required|array|max:10",
            "images.*" => "required|mimetypes:image/*",
            "category" => "required|integer",
            "subcategory" => "required|integer",
            "type" => "required|integer",
            "manufacturer" => "required|integer",
            "sizes" => [
                Rule::requiredIf(function () {
                    return $this->category != 3;
                }),
                "array"
            ],
            "sizes.*" => "required|integer",
            "colors" => "required|array",
            "colors.*" => "required|integer",
            "materials" => "required|array",
            "materials.*" => "required|integer",
            "seasons" => [
                Rule::requiredIf(function () {
                    return $this->category != 3;
                }),
                "array"
            ],
            "seasons.*" => "required|integer"
        ];
    }
}
