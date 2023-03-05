<?php

namespace App\Http\Requests\UpdateRequests;



use Illuminate\Foundation\Http\FormRequest;

class UpdateOfRequest extends FormRequest
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
            // "product_id" =>  "unique:ofs,product_id," . $this->of->id,
            "caliber_id" => 'required',
            // "new_quantity" => 'required|',
            "new_quantity" => "required|min:1|numeric|gte:" . $this->of->quantity
        ];
    }
}
