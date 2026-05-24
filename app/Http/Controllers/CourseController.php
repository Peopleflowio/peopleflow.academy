<?php
namespace App\Http\Controllers;
use App\Models\Academy\Package;
use App\Models\SeatLicense;

class CourseController extends Controller
{
    public function show(Package $package)
    {
        $package->load('modules.lessons');
        $enrolled = auth()->check() 
            ? SeatLicense::where('user_id', auth()->id())->where('package_id', $package->id)->exists()
            : false;
        
        $firstModule = $package->modules->first();
        
        return view('course-detail', compact('package', 'enrolled', 'firstModule'));
    }
}
