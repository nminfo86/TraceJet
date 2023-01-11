<?php

namespace App\Http\Requests\UpdateRequests;


use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            // 'password' => 'sometimes|confirmed',
            'password' => 'sometimes|required|string|min:6|confirmed',
            // 'password' => 'sometimes|confirmed',

            'roles_name' => 'required',
            'name' => 'required',
            'section_id' => 'required',
            'device_name' => 'string'
        ];
    }
    protected function prepareForValidation()
    {
        if ($this->password == null) {
            $this->request->remove('password');
            $this->request->remove('password_confirmation');
        }
    }
}