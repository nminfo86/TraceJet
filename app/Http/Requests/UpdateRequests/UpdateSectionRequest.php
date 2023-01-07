<?php

namespace App\Http\Requests\UpdateRequests;


use Illuminate\Foundation\Http\FormRequest;

class UpdateSectionRequest extends FormRequest
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
            "section_code" => "required|unique:sections,section_code," . $this->section->id,
            "section_name" => "required|unique:sections,section_name," . $this->section->id,
        ];
    }
}
