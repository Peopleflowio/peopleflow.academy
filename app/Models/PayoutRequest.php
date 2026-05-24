<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PayoutRequest extends Model {
    protected $fillable = ['user_id','amount_cents','status','payment_method','payment_details','notes','paid_at'];
    protected $casts = ['paid_at' => 'datetime'];
    public function user() { return $this->belongsTo(User::class); }
}
