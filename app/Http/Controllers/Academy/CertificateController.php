<?php
namespace App\Http\Controllers\Academy;
use App\Http\Controllers\Controller;
use App\Models\Academy\Package;
use App\Models\LessonProgress;
use App\Models\SeatLicense;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function show(Package $package)
    {
        $user = auth()->user();
        
        // Check enrollment
        $enrolled = SeatLicense::where('user_id', $user->id)->where('package_id', $package->id)->exists();
        if (!$enrolled) return redirect()->route('academy.catalog');

        // Calculate completion
        $totalLessons = $package->modules->flatMap->lessons->count();
        $completed = LessonProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $package->modules->flatMap->lessons->pluck('id'))
            ->whereNotNull('completed_at')->count();
        
        $percent = $totalLessons > 0 ? round(($completed / $totalLessons) * 100) : 0;
        $completedAt = LessonProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $package->modules->flatMap->lessons->pluck('id'))
            ->whereNotNull('completed_at')->latest('completed_at')->value('completed_at');

        return view('academy.certificate', compact('user', 'package', 'percent', 'completed', 'totalLessons', 'completedAt'));
    }
}
