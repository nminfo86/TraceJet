<?php

namespace App\Http\Requests\StoreRequests;



use Illuminate\Foundation\Http\FormRequest;

class StoreCaliberRequest extends FormRequest
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
            "caliber_code"      => "required|unique:calibers,caliber_code",
            "caliber_name"      => "required|unique:calibers,caliber_name",
            "product_id"        => "required",
            "box_quantity"      => "required",
        ];
    }
}
