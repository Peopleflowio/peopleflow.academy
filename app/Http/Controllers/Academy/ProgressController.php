<?php
namespace App\Http\Controllers\Academy;
use App\Http\Controllers\Controller;
use App\Models\Academy\Lesson;
use App\Services\Academy\ProgressService;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function __construct(private ProgressService $progress) {}

    public function save(Request $request, Lesson $lesson)
    {
        $data = $request->validate(['watch_seconds' => 'required|integer|min:0']);
        $progress = $this->progress->recordWatch(auth()->user(), $lesson, $data['watch_seconds']);
        return response()->json(['percent' => $progress->percent]);
    }

    public function complete(Request $request, Lesson $lesson)
    {
        $progress = $this->progress->markComplete(auth()->user(), $lesson);
        return response()->json(['completed' => true, 'percent' => 100]);
    }
}
