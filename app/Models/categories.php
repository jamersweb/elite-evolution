<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'reference_type',
        'image',
        'long_description',
        'parent_category',
        'status',

    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cat) {
            if (empty($cat->slug)) {
                $cat->slug = $cat->createSlug($cat->title);
            }
        });
    }

    private function createSlug($title)
    {
        $slug = Str::slug($title);
        if (static::whereSlug($slug)->exists()) {
            $count = static::where('title', $title)->count();
            return "{$slug}-" . ($count + 1);
        }
        return $slug;
    }


}

