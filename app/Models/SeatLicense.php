<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeatLicense extends Model
{
    protected $table = 'seat_licenses';

    protected $fillable = [
        'purchase_id','organization_id','package_id',
        'user_id','assigned_at','revoked_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'revoked_at'  => 'datetime',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function package()
    {
        return $this->belongsTo(\App\Models\Academy\Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('revoked_at');
    }

    public function scopeAssigned($query)
    {
        return $query->whereNotNull('user_id')->whereNull('revoked_at');
    }

    public function isActive(): bool
    {
        return is_null($this->revoked_at);
    }
}