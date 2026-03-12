cat > resources/views/academy/package.blade.php << 'EOF'
@extends('layouts.academy')
@section('title', $package->title)
@section('topbar-title', $package->title)
@section('content')
@php
  $publishedLessonCount = $package->modules->sum(fn($m) => $m->lessons->where('is_published', true)->count());
@endphp

<div style="max-width:800px;margin:0 auto">

  {{-- BREADCRUMB --}}
  <div style="font-size:12.5px;color:var(--ink3);margin-bottom:16px;display:flex;align-items:center;gap:6px">
    <a href="{{ route('academy.catalog') }}" style="color:var(--ink3)">Catalog</a>
    <span>›</span>
    <span style="color:var(--ink)">{{ $package->title }}</span>
  </div>

  {{-- HERO --}}
  <div style="background:linear-gradient(135deg,#1e2d5c,#0a1535);border:1px solid var(--border);border-radius:var(--radius);padding:24px 28px;margin-bottom:20px">
    <div style="display:flex;align-items:flex-start;gap:16px">
      <div style="font-size:42px;flex-shrink:0">{{ $package->emoji_icon }}</div>
      <div style="flex:1">
        <h1 style="font-family:'Instrument Serif',serif;font-size:26px;font-weight:400;color:#fff;margin-bottom:6px">{{ $package->title }}</h1>
        <p style="font-size:13.5px;color:rgba(255,255,255,0.6);margin-bottom:12px;line-height:1.5">{{ $package->description }}</p>
        <div style="display:flex;gap:16px;font-size:13px;color:rgba(255,255,255,0.5)">
          <span>{{ $publishedLessonCount }} lessons</span>
          <span>{{ $package->modules->count() }} {{ Str::plural('module', $package->modules->count()) }}</span>
        </div>
      </div>
      @if(!$hasAccess)
        <div style="text-align:right;flex-shrink:0">
          <div style="font-family:'Geist Mono',monospace;font-size:24px;font-weight:700;color:#fff">{{ $package->price_formatted }}</div>
          <div style="font-size:11px;color:rgba(255,255,255,0.4);margin-top:2px">per seat</div>
        </div>
      @else
        @if(isset($progressData) && $progressData)
          <div style="text-align:right;flex-shrink:0">
            <div style="font-family:'Geist Mono',monospace;font-size:22px;font-weight:700;color:var(--accent)">{{ $progressData['percent'] }}%</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.4);margin-top:2px">complete</div>
          </div>
        @endif
      @endif
    </div>

    @if($hasAccess && isset($progressData) && $progressData['total'] > 0)
      <div style="margin-top:16px">
        <div class="progress-track" style="height:6px">
          <div class="progress-fill progress-fill-blue" style="width:{{ $progressData['percent'] }}%"></div>
        </div>
        <div style="font-size:11px;color:rgba(255,255,255,0.4);margin-top:5px">{{ $progressData['completed'] }} of {{ $progressData['total'] }} lessons complete</div>
      </div>
    @endif
  </div>

  {{-- ACCESS WARNING --}}
  @unless($hasAccess)
    <div style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.2);border-radius:var(--radius);padding:16px 20px;text-align:center;margin-bottom:20px">
      <div style="font-size:24px;margin-bottom:6px">🔒</div>
      <div style="font-size:14px;font-weight:600;color:var(--ink)">Purchase required to access lessons</div>
      <div style="font-size:12.5px;color:var(--ink3);margin-top:4px">Contact your administrator to get access to this package</div>
    </div>
  @endunless

  {{-- CONTINUE BUTTON --}}
  @if($hasAccess && $continueLesson)
    <div style="margin-bottom:16px">
      <a href="{{ route('academy.lesson', [$package->slug, $continueLesson->slug]) }}" class="btn btn-primary" style="width:100%;justify-content:center">
        ▶ Continue — {{ $continueLesson->title }}
      </a>
    </div>
  @endif

  {{-- MODULES & LESSONS --}}
  @foreach($package->modules as $module)
    @php $publishedLessons = $module->lessons->where('is_published', true); @endphp
    @if($publishedLessons->count() > 0)
      <div class="card" style="overflow:hidden;margin-bottom:12px">
        <div style="display:flex;align-items:center;gap:12px;padding:14px 18px;background:var(--surface2);border-bottom:1px solid var(--border)">
          <div style="font-size:20px">{{ $module->emoji_icon }}</div>
          <div>
            <div style="font-size:14px;font-weight:600;color:var(--ink)">{{ $module->title }}</div>
            <div style="font-size:12px;color:var(--ink3)">{{ $publishedLessons->count() }} lessons</div>
          </div>
        </div>
        <div style="divide-y:divide(var(--border))">
          @foreach($publishedLessons as $lesson)
            @php
              $lessonProgress = $lesson->progress->where('user_id', auth()->id())->first();
              $isCompleted = $lessonProgress?->completed_at;
              $pct = $lessonProgress?->percent ?? 0;
            @endphp
            <div style="display:flex;align-items:center;gap:12px;padding:12px 18px;border-bottom:1px solid var(--border);transition:background 0.15s" onmouseover="this.style.background='var(--surface2)'" onmouseout="this.style.background='transparent'">
              <div style="width:28px;height:28px;border-radius:50%;background:{{ $isCompleted ? 'var(--green-bg)' : 'var(--surface2)' }};border:1px solid {{ $isCompleted ? 'rgba(34,197,94,0.2)' : 'var(--border2)' }};display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;color:{{ $isCompleted ? 'var(--green)' : 'var(--ink3)' }};flex-shrink:0">
                {{ $isCompleted ? '✓' : $loop->iteration }}
              </div>
              <div style="flex:1;min-width:0">
                @if($hasAccess)
                  <a href="{{ route('academy.lesson', [$package->slug, $lesson->slug]) }}" style="font-size:14px;font-weight:500;color:var(--ink);display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $lesson->title }}</a>
                @else
                  <span style="font-size:14px;font-weight:500;color:var(--ink3)">{{ $lesson->title }}</span>
                @endif
                <div style="display:flex;align-items:center;gap:8px;margin-top:2px">
                  <span style="font-size:11px;color:var(--ink3)">{{ ucfirst($lesson->difficulty) }}</span>
                  @if($pct > 0 && !$isCompleted)
                    <span style="font-size:11px;color:var(--accent)">{{ $pct }}% watched</span>
                  @endif
                </div>
              </div>
              <span style="font-size:12px;font-family:'Geist Mono',monospace;color:var(--ink3);flex-shrink:0">{{ $lesson->duration_formatted }}</span>
              @if($hasAccess)
                <a href="{{ route('academy.lesson', [$package->slug, $lesson->slug]) }}" style="width:28px;height:28px;border-radius:50%;background:var(--accent-light);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:11px;color:var(--accent)">▶</a>
              @else
                <div style="width:28px;height:28px;border-radius:50%;background:var(--surface2);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:11px;color:var(--ink3)">🔒</div>
              @endif
            </div>
          @endforeach
        </div>
      </div>
    @endif
  @endforeach
</div>
@endsection
EOF