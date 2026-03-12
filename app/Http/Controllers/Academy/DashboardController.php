<?php
namespace App\Http\Controllers\Academy;
use App\Http\Controllers\Controller;
use App\Models\Academy\Package;
use App\Models\LessonProgress;
use App\Services\Academy\{EntitlementService, ProgressService};
class DashboardController extends Controller
{
    public function __construct(
        private EntitlementService $entitlement,
        private ProgressService $progress,
    ) {}
    public function index()
    {
        $user       = auth()->user();
        $packageIds = $this->entitlement->accessiblePackageIds($user);
        $packages   = Package::whereIn('id', $packageIds)->with('modules.lessons')->get();

        $packageProgress = $packages->mapWithKeys(fn($pkg) => [
            $pkg->id => $this->progress->packageProgress($user, $pkg),
        ]);

        $continueLessonPerPackage = $packages->mapWithKeys(fn($pkg) => [
            $pkg->id => $this->progress->continueWatching($user, $pkg),
        ]);

        $continueLesson = $continueLessonPerPackage->filter()->first();

        $totalCompleted    = LessonProgress::where('user_id', $user->id)->whereNotNull('completed_at')->count();
        $totalWatchSeconds = LessonProgress::where('user_id', $user->id)->sum('watch_seconds');

        return view('academy.dashboard', compact(
            'packages','packageProgress','continueLesson',
            'continueLessonPerPackage','totalCompleted','totalWatchSeconds'
        ));
    }
}