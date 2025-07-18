<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Translation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'key',
        'content',
        'tag',
        'language_id'
    ];

    public function language()
    {
    	return $this->belongsTo(Language::class);
    }

    public function scopeGetTranslations($query, $request) {
        
        return Translation::select('translations.id', 'key', 'content', 'tag', 'code AS language_code')
                    ->join('languages', function ($join)
                    {
                        $join->on('translations.language_id', '=', 'languages.id');
                    })->where(function($query) use ($request)
                    {
                        if($request->key != '') {
                            $query->where('key', 'LIKE', '%'.$request->key.'%');
                        }

                        if($request->content != '') {
                            $query->where('content', 'LIKE', '%'.$request->content.'%');
                        }

                        if($request->tag != '') {
                            $query->where('tag', 'LIKE', '%'.$request->tag.'%');
                        }

                        if($request->language_code != '') {
                            $query->where('code', 'LIKE', '%'.$request->language_code.'%');
                        }
                    });
    }
}
