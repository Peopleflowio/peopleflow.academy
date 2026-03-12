@extends('layouts.academy')
@section('title', 'Dashboard')
@section('topbar-title', 'Dashboard')
@section('content')

{{-- HERO --}}
<div style="background:linear-gradient(135deg,#0f1729,#1a2547);border:1px solid var(--border);border-radius:var(--radius);padding:28px 32px">
  <div style="font-size:13px;color:var(--accent);font-weight:500;margin-bottom:6px">👋 Welcome back</div>
  <h1 style="font-family:'Instrument Serif',serif;font-size:30px;font-weight:400;color:var(--ink);margin-bottom:8px">{{ auth()->user()->name }}</h1>
  <p style="font-size:14px;color:var(--ink2);margin-bottom:20px">Pick up where you left off or browse the full catalog.</p>
  <div style="display:flex;gap:10px">
    @if($continueLesson)
      @php
        $continuePackage = $packages->first(function($pkg) use ($continueLesson) {
          return $pkg->modules->contains(function($mod) use ($continueLesson) {
            return $mod->lessons->contains('id', $continueLesson->id);
          });
        });
      @endphp
      @if($continuePackage)
        <a href="{{ route('academy.lesson', [$continuePackage->slug, $continueLesson->slug]) }}" class="btn btn-primary">▶ Continue Learning</a>
      @endif
    @endif
    <a href="{{ route('academy.catalog') }}" class="btn btn-secondary">Browse Catalog</a>
  </div>
</div>

{{-- STATS --}}
@php
  $totalCompleted = \App\Models\LessonProgress::where('user_id', auth()->id())->whereNotNull('completed_at')->count();
  $totalSeconds = \App\Models\LessonProgress::where('user_id', auth()->id())->sum('watch_seconds');
  $hours = round($totalSeconds / 3600, 1);
@endphp
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px">
  <div class="card card-body">
    <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:8px">Lessons Completed</div>
    <div style="font-family:'Instrument Serif',serif;font-size:30px;color:var(--ink);line-height:1">{{ $totalCompleted }}</div>
  </div>
  <div class="card card-body">
    <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:8px">Watch Time</div>
    <div style="font-family:'Instrument Serif',serif;font-size:30px;color:var(--ink);line-height:1">{{ $hours }}h</div>
  </div>
  <div class="card card-body">
    <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:8px">Packages Enrolled</div>
    <div style="font-family:'Instrument Serif',serif;font-size:30px;color:var(--ink);line-height:1">{{ $packages->count() }}</div>
  </div>
  <div class="card card-body">
    <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:8px">In Progress</div>
    <div style="font-family:'Instrument Serif',serif;font-size:30px;color:var(--ink);line-height:1">{{ $packages->count() }}</div>
  </div>
</div>

@if($packages->isNotEmpty())
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
    {{-- CONTINUE WATCHING --}}
    <div>
      <div style="font-size:13px;font-weight:600;color:var(--ink);margin-bottom:12px">Continue Watching</div>
      @foreach($packages as $package)
        @php
          $prog = $packageProgress[$package->id] ?? ['percent'=>0,'completed'=>0,'total'=>0];
          $next = $continueLessonPerPackage[$package->id] ?? null;
        @endphp
        <div class="card" style="margin-bottom:10px;overflow:hidden">
          <div style="display:flex;align-items:center;gap:14px;padding:16px">
            <div style="width:52px;height:52px;border-radius:10px;background:linear-gradient(135deg,#1e2d5c,#0a1535);display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0">{{ $package->emoji_icon }}</div>
            <div style="flex:1;min-width:0">
              <div style="font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:3px">{{ strtoupper($package->title) }}</div>
              <div style="font-size:14px;font-weight:500;color:var(--ink);margin-bottom:6px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                {{ $next?->title ?? 'Start learning' }}
              </div>
              <div class="progress-track">
                <div class="progress-fill progress-fill-blue" style="width:{{ $prog['percent'] }}%"></div>
              </div>
              <div style="font-size:11px;color:var(--ink3);margin-top:4px">{{ $prog['percent'] }}% complete · {{ $prog['completed'] }}/{{ $prog['total'] }} lessons</div>
            </div>
            @if($next)
              <a href="{{ route('academy.lesson', [$package->slug, $next->slug]) }}" class="btn btn-primary btn-sm">Resume</a>
            @else
              <a href="{{ route('academy.package', $package->slug) }}" class="btn btn-primary btn-sm">Start</a>
            @endif
          </div>
        </div>
      @endforeach
    </div>

    {{-- PACKAGE PROGRESS --}}
    <div>
      <div style="font-size:13px;font-weight:600;color:var(--ink);margin-bottom:12px">Package Progress</div>
      @foreach($packages as $package)
        @php $prog = $packageProgress[$package->id] ?? ['percent'=>0,'completed'=>0,'total'=>0]; @endphp
        <div class="card card-body" style="margin-bottom:10px">
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
            <span style="font-size:22px">{{ $package->emoji_icon }}</span>
            <div>
              <div style="font-size:14px;font-weight:600;color:var(--ink)">{{ $package->title }}</div>
              <div style="font-size:12px;color:var(--ink3)">{{ $prog['completed'] }} of {{ $prog['total'] }} lessons complete</div>
            </div>
            <span style="margin-left:auto;font-family:'Geist Mono',monospace;font-size:13px;font-weight:600;color:var(--accent)">{{ $prog['percent'] }}%</span>
          </div>
          <div class="progress-track">
            <div class="progress-fill progress-fill-blue" style="width:{{ $prog['percent'] }}%"></div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@else
  <div class="card card-body" style="text-align:center;padding:40px">
    <div style="font-size:36px;margin-bottom:12px">📚</div>
    <div style="font-size:15px;font-weight:600;color:var(--ink2);margin-bottom:6px">No packages enrolled yet</div>
    <a href="{{ route('academy.catalog') }}" class="btn btn-primary" style="display:inline-flex;margin-top:8px">Browse Catalog →</a>
  </div>
@endif
@endsection
