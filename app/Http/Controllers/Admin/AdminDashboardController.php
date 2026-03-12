<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Academy\Package;
use App\Models\{User, Purchase, SeatLicense, LessonProgress, Organization};

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers     = User::where('role', 'learner')->count();
        $totalRevenue   = Purchase::where('status', 'paid')->sum('amount_cents');
        $totalPurchases = Purchase::where('status', 'paid')->count();
        $activeToday    = LessonProgress::whereDate('updated_at', today())->distinct('user_id')->count();

        $recentPurchases = Purchase::with(['organization', 'package'])
            ->where('status', 'paid')
            ->latest('paid_at')
            ->take(10)
            ->get();

        $users = User::with(['organization'])
            ->where('role', 'learner')
            ->latest()
            ->take(20)
            ->get();

        $packages = Package::withCount(['lessons'])
            ->with('modules')
            ->get()
            ->map(function($pkg) {
                $pkg->seat_count = SeatLicense::where('package_id', $pkg->id)->whereNull('revoked_at')->count();
                $pkg->revenue = Purchase::where('package_id', $pkg->id)->where('status', 'paid')->sum('amount_cents');
                return $pkg;
            });

        return view('admin.dashboard', compact(
            'totalUsers', 'totalRevenue', 'totalPurchases', 'activeToday',
            'recentPurchases', 'users', 'packages'
        ));
    }
}
