<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateDocumentRequest extends FormRequest
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
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'path' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,csv,txt|max:2048',
            'user_id' => 'nullable|exists:users,id',
        ];
    }
}
