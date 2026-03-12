<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchases';

    protected $fillable = [
        'organization_id','package_id',
        'stripe_payment_intent_id','stripe_checkout_session_id',
        'seat_count','amount_cents','currency','status','paid_at',
    ];

    protected $casts = [
        'paid_at'      => 'datetime',
        'seat_count'   => 'integer',
        'amount_cents' => 'integer',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function package()
    {
        return $this->belongsTo(\App\Models\Academy\Package::class);
    }

    public function seatLicenses()
    {
        return $this->hasMany(SeatLicense::class);
    }

    public function markPaid(string $paymentIntentId): void
    {
        $this->update([
            'status'                   => 'paid',
            'paid_at'                  => now(),
            'stripe_payment_intent_id' => $paymentIntentId,
        ]);
    }
}