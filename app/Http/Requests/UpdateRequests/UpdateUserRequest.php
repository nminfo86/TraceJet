<?php

namespace App\Http\Requests\UpdateRequests;


use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'username' => "required|string|unique:users,username," . $this->user->id,
            'password' => 'required_with:password_confirmation|string|min:6|confirmed',
            'roles_name' => 'required',
            'name' => 'required',
            'section_name' => 'required',
            'device_name' => 'string'
        ];
    }
}