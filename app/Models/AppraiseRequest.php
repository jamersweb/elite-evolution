<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppraiseRequest extends Model
{
    use HasFactory;
    public $table = "appraise_request";

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

}
