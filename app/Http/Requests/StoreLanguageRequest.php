<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class StoreLanguageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => [
                'required', 
                'max:10', 
                'unique:'.Language::class
            ],
            'name' => [
                'required', 
                'max:100', 
                'unique:'.Language::class
            ]
        ];

        
    }
}
