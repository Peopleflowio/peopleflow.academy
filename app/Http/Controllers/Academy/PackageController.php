<?php
namespace App\Http\Controllers\Academy;
use App\Http\Controllers\Controller;
use App\Models\Academy\Package;
use App\Services\Academy\{EntitlementService, ProgressService};
class PackageController extends Controller
{
    public function __construct(
        private EntitlementService $entitlement,
        private ProgressService $progress,
    ) {}
    public function show(Package $package)
    {
        abort_if(!$package->is_published, 404);
        $package->load(['modules.lessons.assets', 'modules.lessons.steps']);
        $hasAccess = auth()->check() ? $this->entitlement->hasAccess(auth()->user(), $package) : false;
        $progressData = $hasAccess ? $this->progress->packageProgress(auth()->user(), $package) : [];
        $continueLesson = $hasAccess ? $this->progress->continueWatching(auth()->user(), $package) : null;
        return view('academy.package', compact('package', 'hasAccess', 'progressData', 'continueLesson'));
    }
}
