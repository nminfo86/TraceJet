<?php

namespace App\Http\Requests\StoreRequests;



use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            "posts_type_id"     => "required",
            "post_name"         => 'required|unique:posts,post_name',
            "previous_post"     => "integer",
            "ip_address"               => "required",
            "section_id" => "required",
        ];
    }
}
