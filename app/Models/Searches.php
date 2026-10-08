<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Searches extends Model
{
    use HasFactory;
    public $table = "searches";

    protected $fillable = [
        'user_id',
        'collection',
        'bedrooms',
        'bathrooms',
        'location',
        'property_type',
        'tracking',
        'url',
        'price',
    ];
}
