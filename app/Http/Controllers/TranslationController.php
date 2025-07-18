<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use Illuminate\Http\Request;
use App\Http\Resources\TranslationResource;
use App\Http\Requests\StoreTranslationRequest;
use App\Http\Requests\UpdateTranslationRequest;
use Symfony\Component\HttpFoundation\Response;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit ?? 15;

        $translations = Translation::getTranslations($request)->paginate($limit);

        return TranslationResource::collection($translations);
    }

    public function store(StoreTranslationRequest $request)
    {
        $translation = Translation::create($request->all());
        
        return (new TranslationResource($translation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Translation $translation)
    {
        return new TranslationResource($translation);
    }

    public function update(UpdateTranslationRequest $request, Translation $translation)
    {
        $translation->update($request->validated());

        return (new TranslationResource($translation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);   
    }

    public function destroy(Translation $translation)
    {
        $translation->delete();
        
        return response(null, Response::HTTP_NO_CONTENT);  
    }
}
