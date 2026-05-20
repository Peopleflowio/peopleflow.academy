@extends('layouts.admin')
@section('title', 'Create Quiz')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Create Quiz</h1>
    </div>
    <a href="{{ route('admin.academy.quizzes.index') }}" class="btn btn-secondary">← Back</a>
</div>

<div class="card card-body" style="max-width:600px">
    <form method="POST" action="{{ route('admin.academy.quizzes.store') }}">
        @csrf
        <div class="field">
            <label class="lbl">Package</label>
            <select name="package_id" class="sel" required>
                <option value="">Select package...</option>
                @foreach($packages as $package)
                    <option value="{{ $package->id }}">{{ $package->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label class="lbl">Quiz Title</label>
            <input type="text" name="title" class="inp" required placeholder="e.g. Core HR Foundations Quiz">
        </div>
        <div class="field">
            <label class="lbl">Description</label>
            <textarea name="description" class="txa" rows="2" placeholder="Optional description"></textarea>
        </div>
        <div class="field">
            <label class="lbl">Pass Percentage</label>
            <input type="number" name="pass_percent" class="inp" value="70" min="1" max="100" required>
        </div>
        <div class="field">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                <input type="checkbox" name="is_active" value="1" checked> Active
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Create Quiz</button>
    </form>
</div>
@endsection
