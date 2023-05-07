<?php

namespace App\Http\Requests\UpdateRequests;





use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            "post_name"              => "required|unique:posts,post_name," . $this->post->id,
            "posts_type_id"     => "required",
            "previous_post"     => "integer",
            "ip_address"               => "required",
            "section_id" => "required",
        ];
    }
}
