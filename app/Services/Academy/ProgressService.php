<?php
namespace App\Services\Academy;
use App\Models\Academy\{Lesson, Package};
use App\Models\{LessonProgress, User};
class ProgressService
{
    public function recordWatch(User $user, Lesson $lesson, int $watchSeconds): LessonProgress
    {
        $progress = LessonProgress::firstOrNew([
            'user_id'   => $user->id,
            'lesson_id' => $lesson->id,
        ]);
        if ($watchSeconds > $progress->watch_seconds) {
            $progress->watch_seconds = $watchSeconds;
            $progress->save();
        }
        return $progress;
    }
    public function markComplete(User $user, Lesson $lesson): LessonProgress
    {
        $progress = LessonProgress::firstOrNew([
            'user_id'   => $user->id,
            'lesson_id' => $lesson->id,
        ]);
        if (is_null($progress->completed_at)) {
            $progress->watch_seconds = $lesson->duration_seconds;
            $progress->completed_at  = now();
            $progress->save();
        }
        return $progress;
    }
    public function packageProgress(User $user, Package $package): array
    {
       $lessonIds = $package->lessons()->where('is_published', true)->pluck('lessons.id');
        $completed = LessonProgress::query()
            ->where('user_id', $user->id)
            ->whereIn('lesson_id', $lessonIds)
            ->whereNotNull('completed_at')
            ->count();
        $total = $lessonIds->count();
        return [
            'total'     => $total,
            'completed' => $completed,
            'percent'   => $total > 0 ? (int) round(($completed / $total) * 100) : 0,
        ];
    }
    public function nextLesson(Lesson $lesson): ?Lesson
    {
        return Lesson::query()
            ->where('module_id', $lesson->module_id)
            ->where('sort_order', '>', $lesson->sort_order)
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->first();
    }
    public function continueWatching(User $user, Package $package): ?Lesson
{
    $lessonIds = $package->lessons()->where('is_published', true)->pluck('lessons.id');
    
    // First: return any lesson in progress (started but not completed)
    $inProgress = LessonProgress::query()
        ->where('user_id', $user->id)
        ->whereIn('lesson_id', $lessonIds)
        ->whereNull('completed_at')
        ->latest('updated_at')
        ->first();
    if ($inProgress) return $inProgress->lesson;

    // Second: return next unstarted lesson
    $startedIds = LessonProgress::where('user_id', $user->id)
        ->whereIn('lesson_id', $lessonIds)
        ->pluck('lesson_id');

return $package->lessons()
    ->where('is_published', true)
    ->whereNotIn('lessons.id', $startedIds)
    ->orderBy('lessons.sort_order')
    ->select('lessons.*')
    ->first();
}
}
