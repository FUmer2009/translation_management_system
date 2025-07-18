<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLanguageRequest extends FormRequest
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
                Rule::unique('languages')->ignore($this->language)
            ],
            'name' => [
                'required', 
                'max:100', 
                Rule::unique('languages')->ignore($this->language)
            ]
        ];
    }
}
