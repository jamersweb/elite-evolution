<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;
    public $table = "leads";

    protected $fillable = [
        'status',
        'firstname',
        'lastname',
        'email',
        'mobile',
        'phone',
        'passport_id',
        'passport_expiry_date',
        'address',
        'p_o_box',
        'country',
        'city',
        'land_type',
        'type',
        'property_type',
        'budget',
        'quality',
        'financial_status',
        'source',
        'rep_firstname',
        'rep_lastname',
        'rep_email',
        'rep_phone',
        'time_frame',
        'property_id',
        'assigned_agent_id',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedAgent()
    {
        return $this->belongsTo(User::class, 'assigned_agent_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
