<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code',
        'name'
    ];

    public function scopeGetLanguages($query) {
        
        return Language::select('id', 'code', 'name');
    }
}
