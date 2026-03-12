<?php

namespace App\Models\Academy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Lesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lessons';

    protected $fillable = [
        'module_id','slug','title','description',
        'process_type','difficulty','duration_seconds',
        'is_published','sort_order',
    ];

    protected $casts = [
        'is_published'     => 'boolean',
        'duration_seconds' => 'integer',
        'sort_order'       => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Lesson $lesson) {
            if (empty($lesson->slug)) {
                $lesson->slug = Str::slug($lesson->title) . '-' . Str::random(4);
            }
        });
    }

    public function module()
    {
        return $this->belongsTo(PackageModule::class, 'module_id');
    }

    public function steps()
    {
        return $this->hasMany(LessonStep::class)->orderBy('sort_order');
    }

    public function assets()
    {
        return $this->hasMany(LessonAsset::class)->orderBy('sort_order');
    }

    public function videoAsset()
    {
        return $this->hasOne(LessonAsset::class)->where('type', 'video');
    }

    public function progress()
    {
        return $this->hasMany(\App\Models\LessonProgress::class);
    }

    public function getDurationFormattedAttribute(): string
    {
        $m = intdiv($this->duration_seconds, 60);
        $s = $this->duration_seconds % 60;
        return sprintf('%d:%02d', $m, $s);
    }

    public function getHasVideoAttribute(): bool
    {
        return $this->assets()->where('type', 'video')->exists();
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}