<?php
namespace App\Http\Controllers\Academy;
use App\Http\Controllers\Controller;
use App\Models\Academy\{Package, Lesson};
use App\Models\LessonProgress;
use App\Services\Academy\{EntitlementService, ProgressService, VideoUrlService};
class LessonController extends Controller
{
    public function __construct(
        private EntitlementService $entitlement,
        private ProgressService $progress,
        private VideoUrlService $videoUrl,
    ) {}
    public function show(Package $package, Lesson $lesson)
    {
        abort_if(!$package->is_published || !$lesson->is_published, 404);
        $lesson->load(['steps', 'assets', 'module']);
        $videoUrl     = null;
        $userProgress = null;

        // Check if this lesson is in the first module (free preview)
        $firstModule = $package->modules()->orderBy('sort_order')->first();
        $isFreePreview = $firstModule && $lesson->module_id === $firstModule->id;

        $hasAccess = auth()->check() && $this->entitlement->hasAccess(auth()->user(), $package);

        if ($hasAccess || $isFreePreview) {
            $videoAsset = $lesson->videoAsset;
            if ($videoAsset) {
                try { $videoUrl = $this->videoUrl->generateStreamUrl($videoAsset); } catch (\Exception $e) {}
            }
            if (auth()->check()) {
                $userProgress = LessonProgress::firstOrNew(['user_id' => auth()->id(), 'lesson_id' => $lesson->id]);
            }
        }
        $nextLesson = $this->progress->nextLesson($lesson);
        $prevLesson = Lesson::where('module_id', $lesson->module_id)
            ->where('sort_order', '<', $lesson->sort_order)
            ->where('is_published', true)
            ->orderByDesc('sort_order')->first();
        return view('academy.lesson', compact('package','lesson','videoUrl','userProgress','nextLesson','prevLesson'));
    }
}
