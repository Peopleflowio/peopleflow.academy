<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonProgress extends Model
{
    protected $table = 'lesson_progress';

    protected $fillable = [
        'user_id','lesson_id','watch_seconds','completed_at'
    ];

    protected $casts = [
        'completed_at'  => 'datetime',
        'watch_seconds' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(\App\Models\Academy\Lesson::class);
    }

   public function getPercentAttribute(): int
{
    if ($this->completed_at) return 100;
    $duration = $this->lesson->duration_seconds;
    if (!$duration) return 0;
    return min(99, (int) round(($this->watch_seconds / $duration) * 100));
}
}