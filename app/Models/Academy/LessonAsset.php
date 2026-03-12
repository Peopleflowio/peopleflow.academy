<?php

namespace App\Models\Academy;

use Illuminate\Database\Eloquent\Model;

class LessonAsset extends Model
{
    protected $table = 'lesson_assets';

    protected $fillable = [
        'lesson_id','type','label','s3_key','external_url',
        'file_size_bytes','mime_type','duration_seconds','sort_order',
    ];

    protected $casts = [
        'file_size_bytes'  => 'integer',
        'duration_seconds' => 'integer',
        'sort_order'       => 'integer',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function getFileSizeFormattedAttribute(): string
    {
        $b = $this->file_size_bytes;
        if ($b > 1_073_741_824) return round($b / 1_073_741_824, 1) . ' GB';
        if ($b > 1_048_576)     return round($b / 1_048_576, 1) . ' MB';
        return round($b / 1024, 0) . ' KB';
    }
}