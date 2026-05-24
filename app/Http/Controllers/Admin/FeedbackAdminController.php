<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Feedback;

class FeedbackAdminController extends Controller
{
    public function index()
    {
        $feedback = Feedback::with(['user','package'])->latest()->get();
        $avgOverall = $feedback->avg('rating_overall');
        $avgContent = $feedback->avg('rating_content');
        $avgPlatform = $feedback->avg('rating_platform');
        $recommended = $feedback->where('would_recommend', true)->count();
        return view('admin.feedback', compact('feedback','avgOverall','avgContent','avgPlatform','recommended'));
    }
}
