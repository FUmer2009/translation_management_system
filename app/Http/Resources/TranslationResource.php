<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TranslationResource extends JsonResource
{
    protected $languageCode;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'key'           => $this->key,
            'content'       => $this->content,
            'tag'           => $this->tag,
            $this->mergeWhen($this->languageCode($request), [
                'language_code' => $this->languageCode
            ]),   
        ];
    }

    protected function languageCode($request)
    {
        $route = $request->route()->getName();

        $this->languageCode = ($route === 'translations.index') ? $this->language_code : $this->language->code;
    
        return $this->languageCode;
    }
}
