<?php

namespace App\Models\Academy;

use Illuminate\Database\Eloquent\Model;

class LessonStep extends Model
{
    protected $table = 'lesson_steps';

    protected $fillable = [
        'lesson_id','title','description','nav_path','sort_order'
    ];

    protected $casts = ['sort_order' => 'integer'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}