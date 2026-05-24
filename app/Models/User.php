<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'organization_id',
        'referral_code',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isLearner(): bool
    {
        return $this->role === 'learner';
    }

    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function referredBy()
    {
        return $this->hasOne(Referral::class, 'referred_id');
    }

    public function generateReferralCode(): string
    {
        $code = strtoupper(substr(str_replace(['+','/','='], '', base64_encode($this->name)), 0, 4) . str_pad($this->id, 4, '0', STR_PAD_LEFT));
        $this->update(['referral_code' => $code]);
        return $code;
    }

    public function getReferralCodeAttribute($value): string
    {
        if (!$value) {
            return $this->generateReferralCode();
        }
        return $value;
    }
}
