@extends('layouts.admin')
@section('title', 'Lessons')
@section('breadcrumb', 'Lessons & Videos')
@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Lessons & Videos</div>
    <div class="page-sub">Manage all lesson content and video assets</div>
  </div>
  <div class="page-actions">
    <a href="{{ route('admin.academy.lessons.create') }}" class="btn btn-primary">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      New Lesson
    </a>
  </div>
</div>

@foreach($packages as $package)
  <div style="margin-bottom:6px;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);display:flex;align-items:center;gap:8px">
    <span>{{ $package->emoji_icon }}</span> {{ $package->title }}
  </div>
  @foreach($package->modules as $module)
    <div class="module-block" style="margin-bottom:16px">
      <div class="module-header">
        <div class="module-icon">{{ $module->emoji_icon }}</div>
        <div>
          <div class="module-title">{{ $module->title }}</div>
          <div class="module-sub">{{ $module->lessons->count() }} lessons</div>
        </div>
        <div style="margin-left:auto">
          <a href="{{ route('admin.academy.lessons.create', ['module_id' => $module->id]) }}" class="btn btn-secondary btn-sm">+ Add Lesson</a>
        </div>
      </div>
      <div class="module-body">
        @forelse($module->lessons as $i => $lesson)
          <div class="lesson-row">
            @if($lesson->has_video)
              <div class="has-video">🎬</div>
            @else
              <div class="no-video">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="5 3 19 12 5 21 5 3"/></svg>
              </div>
            @endif
            <div class="lesson-num">{{ $i + 1 }}</div>
            <div class="lesson-info">
              <div class="lesson-name">{{ $lesson->title }}</div>
              <div class="lesson-meta">
                <span>{{ ucfirst($lesson->process_type) }}</span>
                <span style="color:var(--border-dark)">·</span>
                <span>{{ ucfirst($lesson->difficulty) }}</span>
                <span style="color:var(--border-dark)">·</span>
                <span style="font-family:'Geist Mono',monospace">{{ $lesson->duration_formatted }}</span>
              </div>
            </div>
            @if($lesson->is_published)
              <span class="badge badge-green"><span class="dot dot-green"></span> Published</span>
            @else
              <span class="badge badge-amber"><span class="dot dot-amber"></span> Draft</span>
            @endif
            <a href="{{ route('admin.academy.lessons.edit', $lesson) }}" class="btn btn-secondary btn-xs">Edit</a>
          </div>
        @empty
          <div style="padding:16px;text-align:center;color:var(--ink3);font-size:13px">No lessons yet in this module</div>
        @endforelse
      </div>
    </div>
  @endforeach
@endforeach
@endsection
