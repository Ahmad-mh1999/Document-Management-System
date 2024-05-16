<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
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
            'content' => 'nullable|string|min:10|max:1000',
            'user_id' => 'nullable|exists:users,id|unique:comments,user_id',
            'commentable_id' => 'nullable|exists:documents,id|unique:comments,commentable_id',
            'commentable_type' => 'nullable|string',
        ];
    }
}
