<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\Base\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends ApiRequest
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
        return $this->isMethod('POST') ? [
            'title' => ['required', 'string'],
            'body' => ['required', 'string'],
            'image' => ['required', 'image'],
            'tags' => ['required'],
            'stats' => ['nullable'],
        ] : [
            'title' => ['required', 'string'],
            'body' => ['required', 'string'],
            'image' => ['nullable', 'image'],
            'tags' => ['required'],
            'stats' => ['nullable'],
        ];
    }
}
