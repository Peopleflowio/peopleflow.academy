<?php
namespace App\Http\Controllers\Academy;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Academy\Package;
use App\Models\SeatLicense;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function show(Package $package)
    {
        $enrolled = SeatLicense::where('user_id', auth()->id())->where('package_id', $package->id)->exists();
        if (!$enrolled) return redirect()->route('academy.catalog');

        $quiz = Quiz::where('package_id', $package->id)->where('is_active', true)->with('questions')->first();
        if (!$quiz) return redirect()->route('academy.package', $package->slug)->with('info', 'No quiz available yet.');

        $lastAttempt = QuizAttempt::where('user_id', auth()->id())->where('quiz_id', $quiz->id)->latest()->first();

        return view('academy.quiz', compact('package', 'quiz', 'lastAttempt'));
    }

    public function submit(Request $request, Package $package)
    {
        $quiz = Quiz::where('package_id', $package->id)->where('is_active', true)->with('questions')->firstOrFail();
        $answers = $request->input('answers', []);
        $score = 0;
        $results = [];

        foreach ($quiz->questions as $question) {
            $given = $answers[$question->id] ?? null;
            $correct = $given === $question->correct_answer;
            if ($correct) $score++;
            $results[$question->id] = [
                'given' => $given,
                'correct' => $question->correct_answer,
                'is_correct' => $correct,
                'explanation' => $question->explanation,
            ];
        }

        $total = $quiz->questions->count();
        $percent = $total > 0 ? round(($score / $total) * 100) : 0;
        $passed = $percent >= $quiz->pass_percent;

        $attempt = QuizAttempt::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
            'total' => $total,
            'percent' => $percent,
            'passed' => $passed,
            'answers' => $results,
        ]);

        return view('academy.quiz-result', compact('package', 'quiz', 'attempt', 'results'));
    }
}
