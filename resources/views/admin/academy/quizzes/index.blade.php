@extends('layouts.admin')
@section('title', 'Quizzes')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Quizzes</h1>
        <p class="page-sub">Manage quizzes for each course package</p>
    </div>
    <a href="{{ route('admin.academy.quizzes.create') }}" class="btn btn-primary">+ New Quiz</a>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <table class="tbl">
        <thead><tr><th>Quiz</th><th>Package</th><th>Questions</th><th>Pass %</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse($quizzes as $quiz)
            <tr>
                <td><strong>{{ $quiz->title }}</strong></td>
                <td>{{ $quiz->package?->title ?? '—' }}</td>
                <td>{{ $quiz->questions->count() }}</td>
                <td>{{ $quiz->pass_percent }}%</td>
                <td><span class="badge {{ $quiz->is_active ? 'badge-green' : 'badge-red' }}">{{ $quiz->is_active ? 'Active' : 'Inactive' }}</span></td>
                <td><a href="{{ route('admin.academy.quizzes.edit', $quiz) }}" class="btn btn-sm btn-secondary">Edit</a></td>
            </tr>
        @empty
            <tr><td colspan="6" style="text-align:center;color:var(--ink3);padding:32px">No quizzes yet</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
