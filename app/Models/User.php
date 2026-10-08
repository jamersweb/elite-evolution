<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'image',
        'brn',
        'experience',
        'occupation',
        'about',
        'password',
        'whatsapp_no',
        'linkedin_url',
        'area_tags',
        'language_multi_select',
        'nationality',
        'status',
        'is_agent',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_agent' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->slug)) {
                $user->slug = $user->createSlug($user->name);
            }
        });
    }

    private function createSlug($name)
    {
        $slug = Str::slug($name);
        if (static::whereSlug($slug)->exists()) {
            $count = static::where('name', $name)->count();
            return "{$slug}-" . ($count + 1);
        }
        return $slug;
    }

    /**
     * Safe fallback for legacy code calling ->role(...) on User instance instead of ->hasRole(...)
     */
    public function role($roles)
    {
        return $this->hasRole($roles);
    }

    public function scopeAgents($query)
    {
        return $query->where(function ($q) {
            $q->where('is_agent', true)
              ->orWhereHas('roles', function ($r) {
                  $r->whereIn('name', ['agent', 'Agent', 'eliteagent']);
              });
        });
    }

    public function reactions($referencetype = null, $reactiontype = null)
    {
        $rel = $this->hasMany(Reaction::class, 'user_id');
        if ($referencetype) {
            $rel->where('reference_type', $referencetype);
        }
        if ($reactiontype) {
            $rel->where('type', $reactiontype);
        }
        return $rel;
    }

    public function searches()
    {
        return $this->hasMany(Searches::class, 'user_id');
    }

    public function property()
    {
        return $this->hasMany(Property::class, 'user_id');
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'user_id');
    }
}
