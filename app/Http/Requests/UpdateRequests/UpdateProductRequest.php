<?php

namespace App\Http\Requests\UpdateRequests;


use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "product_code" => "required|unique:products,product_code," . $this->product->id,
            "product_name" => "required|unique:products,product_name," . $this->product->id,
            "section_id"        => "required",
        ];
    }
}
