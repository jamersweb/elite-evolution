<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Property;

class Developer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'image',
        'cover',
        'name',
        'slug',
        'description',
        'status',
        'meta_title',
        'meta_description',
        'meta_tag',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($dev) {
            if (empty($dev->slug)) {
                $dev->slug = $dev->createSlug($dev->name);
            }
        });
    }

    private function createSlug($title)
    {
        $slug = Str::slug($title);
        if (static::whereSlug($slug)->exists()) {
            $count = static::where('name', $title)->count();
            return "{$slug}-" . ($count + 1);
        }
        return $slug;
    }


    public function property()
    {
        return $this->hasMany(Property::class, 'developer_id', 'id');
    }

}
