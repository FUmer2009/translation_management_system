<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Resources\LanguageResource;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use Symfony\Component\HttpFoundation\Response;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit ?? 15;

        $languages = Language::getLanguages()->paginate($limit);
        
        return LanguageResource::collection($languages );
    }

    public function store(StoreLanguageRequest $request)
    {
        $language = Language::create($request->validated());
        
        return (new LanguageResource($language))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Language $language)
    {
        return new LanguageResource($language);
    }

    public function update(UpdateLanguageRequest $request, Language $language)
    {
        $language->update($request->validated());

        return (new LanguageResource($language))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);   
    }

    public function destroy(Language $language)
    {
        $language->delete();
        
        return response(null, Response::HTTP_NO_CONTENT);  
    }
}
