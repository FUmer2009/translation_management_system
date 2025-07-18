<?php

namespace App\Http\Requests;

use App\EnumsTag;
use App\Models\Language;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTranslationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'key'=> [
                'required',
                'max:255',
                Rule::unique('translations')
                    ->where(fn (Builder $query) => 
                        $query->where('language_id', $this->language_id)
                            ->where('tag', $this->tag)
                    )->ignore($this->translation)
            ],
            'content' => [
                'required'
            ],
            'tag'  => [
                Rule::enum(EnumsTag::class)
            ],
            'language_id' => [
                'required',
                'exists:'.Language::class.',id'
            ],
        ];
    }
}
