<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class media extends Model
{
    use HasFactory;
    public function getDisplayUrlAttribute()
    {
        return $this->source_url ?: asset('images/media/' . $this->image);
    }

    protected $fillable = [
        'reference_id',
        'reference_type',
        'caption',
        'image',
    ];
}
