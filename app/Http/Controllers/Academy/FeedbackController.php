<?php
namespace App\Http\Controllers\Academy;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Academy\Package;
use App\Models\SeatLicense;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $packages = SeatLicense::where('user_id', $user->id)
            ->with('package')
            ->get()
            ->pluck('package')
            ->filter();
        
        $submitted = Feedback::where('user_id', $user->id)->pluck('package_id')->toArray();
        
        return view('academy.feedback', compact('packages', 'submitted'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'rating_overall' => 'required|integer|min:1|max:5',
            'rating_content' => 'required|integer|min:1|max:5',
            'rating_platform' => 'required|integer|min:1|max:5',
            'would_recommend' => 'required|boolean',
        ]);

        $existing = Feedback::where('user_id', auth()->id())
            ->where('package_id', $request->package_id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already submitted feedback for this course.');
        }

        Feedback::create([
            'user_id' => auth()->id(),
            'package_id' => $request->package_id,
            'rating_overall' => $request->rating_overall,
            'rating_content' => $request->rating_content,
            'rating_platform' => $request->rating_platform,
            'would_recommend' => $request->would_recommend,
            'liked' => $request->liked,
            'improve' => $request->improve,
            'comments' => $request->comments,
        ]);

        return back()->with('success', 'Thank you for your feedback! 🎉');
    }
}
