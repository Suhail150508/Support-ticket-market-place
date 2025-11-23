<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePageContent extends Model
{
  protected $fillable = [
        'section_key',
        'section_name',
        'content',
        'is_active',
        'sort_order',
        'image',
    ];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
    ];

    public static function getContent($sectionKey)
    {
        $content = self::where('section_key', $sectionKey)
            ->where('is_active', true)
            ->first();
        
        return $content ? $content->content : null;
    }
}
