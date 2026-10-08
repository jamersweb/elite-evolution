<?php

namespace App\Models;

use App\Models\media;
use App\Models\Amenities;
use App\Models\Developer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;
    public $table = "properties";

    protected $fillable = [
        'status',
        'user_id',
        'developer_id',
        'reference_no',
        'trakheesi_permit_no',
        'permit_qr_image',
        'title',
        'slug',
        'description',
        'deeds',
        'land_type',
        'type',
        'property_type',
        'completion_status',
        'handover_date',
        'furnishing_type',
        'layout_type',
        'build_up_area',
        'bedrooms',
        'bathrooms',
        'parkings',
        'size',
        'financial_status',
        'project_status',
        'amenities',
        'price',
        'end_price',
        'yearly_rent',
        'cheques',
        'deposit',
        'available_from',
        'view36',
        'video',
        'location',
        'map',
        'brochure',
        'service_charges',
        'country',
        'state',
        'community',
        'sub_community',
        'building',
        'address',
        'postcode',
        'lat',
        'lng',
        'completesearch',
        'is_verified',
        'is_new_project',
        'meta_title',
        'meta_description',
        'meta_tag',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($property) {
            if (empty($property->slug)) {
                $property->slug = $property->createSlug($property->title);
            }
            if (empty($property->reference_no)) {
                $property->reference_no = 'EERE-' . strtoupper(Str::random(3)) . '-' . rand(100, 999);
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

    public function media()
    {
        return $this->hasMany(media::class, 'reference_id')->where('reference_type', 'property');
    }

    public function featuredImage()
    {
        return $this->hasOne(media::class, 'reference_id')->where('reference_type', 'property');
    }

    public function developer()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAmenitiesAttribute()
    {
        if (!empty($this->attributes['amenities']) && $this->attributes['amenities'] != 'null') {
            $amenitiesIds = json_decode($this->attributes['amenities'], true);
            if (is_array($amenitiesIds) && count($amenitiesIds) > 0) {
                return Amenities::whereIn('id', $amenitiesIds)->get();
            }
        }
        return collect();
    }
}
