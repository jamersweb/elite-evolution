<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;
    public $table = "career";

    protected $fillable = [
        'name',
        'email',
        'phone',
        'resume',
        'cover',
    ];

}
