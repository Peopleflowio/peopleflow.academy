<?php
namespace App\Http\Controllers\Admin\Academy;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Academy\Package;
use Illuminate\Http\Request;

class QuizAdminController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('package')->latest()->get();
        return view('admin.academy.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $packages = Package::where('is_published', true)->orderBy('title')->get();
        return view('admin.academy.quizzes.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'title' => 'required|string|max:255',
            'pass_percent' => 'required|integer|min:1|max:100',
        ]);
        Quiz::create($request->only('package_id','title','description','pass_percent','is_active'));
        return redirect()->route('admin.academy.quizzes.index')->with('success', 'Quiz created!');
    }

    public function edit(Quiz $quiz)
    {
        $quiz->load('questions');
        $packages = Package::where('is_published', true)->orderBy('title')->get();
        return view('admin.academy.quizzes.edit', compact('quiz', 'packages'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $quiz->update($request->only('title','description','pass_percent','is_active'));
        return back()->with('success', 'Quiz updated!');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.academy.quizzes.index')->with('success', 'Quiz deleted!');
    }

    public function addQuestion(Request $request, Quiz $quiz)
    {
        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);
        QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_answer' => $request->correct_answer,
            'explanation' => $request->explanation,
            'sort_order' => $quiz->questions()->count() + 1,
        ]);
        return back()->with('success', 'Question added!');
    }

    public function deleteQuestion(Quiz $quiz, QuizQuestion $question)
    {
        $question->delete();
        return back()->with('success', 'Question deleted!');
    }
}
