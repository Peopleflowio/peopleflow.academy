<?php

namespace App\Models\Academy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Package extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'packages';

    protected $fillable = [
        'slug','title','description','thumbnail_path',
        'emoji_icon','price_cents','currency','is_published','sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'price_cents'  => 'integer',
        'sort_order'   => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Package $pkg) {
            if (empty($pkg->slug)) {
                $pkg->slug = Str::slug($pkg->title);
            }
        });
    }

    public function modules()
    {
        return $this->hasMany(PackageModule::class)->orderBy('sort_order');
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, PackageModule::class, 'package_id', 'module_id');
    }

    public function purchases()
    {
        return $this->hasMany(\App\Models\Purchase::class);
    }

    public function seatLicenses()
    {
        return $this->hasMany(\App\Models\SeatLicense::class);
    }

    public function getPriceFormattedAttribute(): string
    {
        return '$' . number_format($this->price_cents / 100, 2);
    }

    public function getLessonCountAttribute(): int
    {
    return $this->lessons()->where('is_published', true)->count();
}

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}