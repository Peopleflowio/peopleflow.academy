<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AdminAuditLog extends Model
{
    protected $table = 'admin_audit_logs';
    public $timestamps = false;
    protected $fillable = ['user_id','action','subject_type','subject_id','payload','ip_address','user_agent'];
    protected $casts = ['payload' => 'array', 'created_at' => 'datetime'];
    public function save(array $options = []) {
        if (!$this->exists) { $this->created_at = now(); }
        return parent::save($options);
    }
    public static function record(string $action, mixed $subject = null, array $payload = []): self {
        return static::create([
            'user_id'      => auth()->id(),
            'action'       => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id'   => $subject?->id,
            'payload'      => $payload ?: null,
            'ip_address'   => request()->ip(),
            'user_agent'   => request()->userAgent(),
        ]);
    }
}
