@extends('layouts.admin')
@section('title', 'Edit Quiz')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $quiz->title }}</h1>
        <p class="page-sub">{{ $quiz->questions->count() }} questions</p>
    </div>
    <a href="{{ route('admin.academy.quizzes.index') }}" class="btn btn-secondary">← Back</a>
</div>

@if(session('success'))
    <div class="alert-success" style="margin-bottom:16px">{{ session('success') }}</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:start">

{{-- Quiz Settings --}}
<div class="card card-body">
    <h2 style="font-size:15px;font-weight:600;margin-bottom:16px">Quiz Settings</h2>
    <form method="POST" action="{{ route('admin.academy.quizzes.update', $quiz) }}">
        @csrf @method('PATCH')
        <div class="field">
            <label class="lbl">Title</label>
            <input type="text" name="title" class="inp" value="{{ $quiz->title }}" required>
        </div>
        <div class="field">
            <label class="lbl">Description</label>
            <textarea name="description" class="txa" rows="2">{{ $quiz->description }}</textarea>
        </div>
        <div class="field">
            <label class="lbl">Pass %</label>
            <input type="number" name="pass_percent" class="inp" value="{{ $quiz->pass_percent }}" min="1" max="100">
        </div>
        <div class="field">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                <input type="checkbox" name="is_active" value="1" {{ $quiz->is_active ? 'checked' : '' }}> Active
            </label>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Save Settings</button>
    </form>
</div>

{{-- Add Question --}}
<div class="card card-body">
    <h2 style="font-size:15px;font-weight:600;margin-bottom:16px">Add Question</h2>
    <form method="POST" action="{{ route('admin.academy.quizzes.questions.store', $quiz) }}">
        @csrf
        <div class="field">
            <label class="lbl">Question</label>
            <textarea name="question" class="txa" rows="2" required placeholder="Enter question..."></textarea>
        </div>
        <div class="field">
            <label class="lbl">Option A</label>
            <input type="text" name="option_a" class="inp" required>
        </div>
        <div class="field">
            <label class="lbl">Option B</label>
            <input type="text" name="option_b" class="inp" required>
        </div>
        <div class="field">
            <label class="lbl">Option C</label>
            <input type="text" name="option_c" class="inp" placeholder="Optional">
        </div>
        <div class="field">
            <label class="lbl">Option D</label>
            <input type="text" name="option_d" class="inp" placeholder="Optional">
        </div>
        <div class="field">
            <label class="lbl">Correct Answer</label>
            <select name="correct_answer" class="sel" required>
                <option value="a">A</option>
                <option value="b">B</option>
                <option value="c">C</option>
                <option value="d">D</option>
            </select>
        </div>
        <div class="field">
            <label class="lbl">Explanation (optional)</label>
            <textarea name="explanation" class="txa" rows="2" placeholder="Why is this the correct answer?"></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Add Question</button>
    </form>
</div>
</div>

{{-- Questions List --}}
<div style="margin-top:24px">
    <h2 style="font-size:15px;font-weight:600;margin-bottom:16px">Questions ({{ $quiz->questions->count() }})</h2>
    @forelse($quiz->questions as $i => $q)
        <div class="card card-body" style="margin-bottom:12px">
            <div style="display:flex;justify-content:space-between;align-items:flex-start">
                <div style="flex:1">
                    <div style="font-size:11px;color:var(--ink3);margin-bottom:4px">Q{{ $i+1 }}</div>
                    <div style="font-size:14px;font-weight:600;color:var(--ink);margin-bottom:10px">{{ $q->question }}</div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px">
                        @foreach(['a'=>$q->option_a,'b'=>$q->option_b,'c'=>$q->option_c,'d'=>$q->option_d] as $key=>$opt)
                            @if($opt)
                                <div style="font-size:13px;padding:6px 10px;border-radius:6px;{{ $key === $q->correct_answer ? 'background:#dcfce7;color:#16a34a;font-weight:600' : 'background:var(--bg);color:var(--ink2)' }}">
                                    {{ strtoupper($key) }}. {{ $opt }} {{ $key === $q->correct_answer ? '✓' : '' }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @if($q->explanation)
                        <div style="font-size:12px;color:var(--ink3);margin-top:8px;font-style:italic">💡 {{ $q->explanation }}</div>
                    @endif
                </div>
                <form method="POST" action="{{ route('admin.academy.quizzes.questions.destroy', [$quiz, $q]) }}" style="margin-left:16px">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm" style="background:#fee2e2;color:#dc2626;border:none" onclick="return confirm('Delete this question?')">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <div class="card card-body" style="text-align:center;color:var(--ink3)">No questions yet — add one above!</div>
    @endforelse
</div>
@endsection
