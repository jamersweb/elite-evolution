<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blog extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'category_id',
        'reference_type',
        'image',
        'long_description',
        'short_description',
        'status',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($b) {
            if (empty($b->slug)) {
                $b->slug = $b->createSlug($b->title);
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

    public function featuredImage()
    {
        return $this->hasOne(media::class, 'reference_id')->where('reference_type', 'blog');
    }

    public function getCoverImageAttribute()
    {
        return $this->image ?: optional($this->featuredImage)->image;
    }
}

