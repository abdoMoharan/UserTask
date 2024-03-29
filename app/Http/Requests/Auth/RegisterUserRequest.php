<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Base\ApiRequest;

class RegisterUserRequest extends ApiRequest
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
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|min:10|max:20|unique:users',
            'password' => 'required|string|min:6',
        ];
    }
}
