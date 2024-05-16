<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeDocumentRequest extends FormRequest
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
            'name' => 'required|string',
            'path' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,csv,txt|max:2048',
            'user_id' => 'required|exists:users,id',
        ];
    }
}
