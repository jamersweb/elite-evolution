<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyInquiry extends Model
{
    use HasFactory;
    public $table = "property_inquiries";

    protected $fillable = [
        'property_id',
        'name',
        'email',
        'phone',
        'message',
        'type',
        'assigned_agent_id',
        'status',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function assignedAgent()
    {
        return $this->belongsTo(User::class, 'assigned_agent_id');
    }
}
