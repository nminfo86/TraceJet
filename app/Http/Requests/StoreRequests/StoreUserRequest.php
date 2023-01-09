<?php

namespace App\Http\Requests\StoreRequests;



use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'username' => "required|string|unique:users,username",
            'password' => 'required_with:password_confirmation|string|min:6|confirmed',
            'roles_name' => 'required',
            'name' => 'required',
            'section_id' => 'required',
            'device_name' => 'string'
        ];
    }
}
