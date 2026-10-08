<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingRequest extends Model
{
    use HasFactory;
    public $table = "listing_request";

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'type',
    ];

}
