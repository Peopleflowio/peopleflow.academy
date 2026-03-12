<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TrainingTenantAccess extends Model
{
    protected $table = 'training_tenant_accesses';
    protected $fillable = ['organization_id','user_id','package_id','issued_by','tenant_ref','starts_at','expires_at','notes','revoked_at'];
    protected $casts = ['tenant_ref' => 'encrypted','starts_at' => 'datetime','expires_at' => 'datetime','revoked_at' => 'datetime'];
    protected $hidden = ['tenant_ref'];
    public function organization() { return $this->belongsTo(Organization::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function package() { return $this->belongsTo(\App\Models\Academy\Package::class); }
    public function issuedBy() { return $this->belongsTo(User::class, 'issued_by'); }
    public function scopeActive($query) { return $query->whereNull('revoked_at')->where('expires_at', '>', now()); }
    public function isExpired(): bool { return $this->expires_at->isPast(); }
    public function isRevoked(): bool { return !is_null($this->revoked_at); }
    public function isExpiringSoon(): bool { return $this->expires_at->isBetween(now(), now()->addDays(14)); }
    public function getStatusAttribute(): string {
        if ($this->isRevoked()) return 'revoked';
        if ($this->isExpired()) return 'expired';
        if ($this->isExpiringSoon()) return 'expiring';
        return 'active';
    }
}
