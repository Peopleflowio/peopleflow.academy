@extends('layouts.academy')
@section('title', $lesson->title)
@section('topbar-title', $lesson->title)
@section('content')
<div style="max-width:900px;margin:0 auto">

  {{-- BREADCRUMB --}}
  <div style="font-size:12.5px;color:var(--ink3);margin-bottom:16px;display:flex;align-items:center;gap:6px">
    <a href="{{ route('academy.catalog') }}" style="color:var(--ink3);hover:color:var(--ink)">Catalog</a>
    <span>›</span>
    <a href="{{ route('academy.package', $package->slug) }}" style="color:var(--ink3)">{{ $package->title }}</a>
    <span>›</span>
    <span style="color:var(--ink)">{{ $lesson->title }}</span>
  </div>

  {{-- VIDEO PLAYER --}}
  <div style="background:#000;border-radius:var(--radius);overflow:hidden;aspect-ratio:16/9;margin-bottom:20px;position:relative">
    @if($videoUrl)
      <video id="lesson-video" class="w-full h-full" style="width:100%;height:100%" controls controlsList="nodownload" oncontextmenu="return false" preload="metadata">
        <source src="{{ $videoUrl }}" type="video/mp4">
      </video>
    @else
      <div style="display:flex;align-items:center;justify-content:center;height:100%;color:var(--ink3)">
        <div style="text-align:center">
          <div style="font-size:48px;margin-bottom:12px">🎬</div>
          <div style="font-size:14px">No video uploaded yet</div>
        </div>
      </div>
    @endif
  </div>

  <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start">

    {{-- LEFT: LESSON INFO --}}
    <div>
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
        <span class="badge badge-blue">{{ ucfirst($lesson->process_type) }}</span>
        <span class="badge badge-{{ $lesson->difficulty === 'beginner' ? 'green' : ($lesson->difficulty === 'advanced' ? 'amber' : 'blue') }}">{{ ucfirst($lesson->difficulty) }}</span>
        <span style="font-size:12px;color:var(--ink3);font-family:'Geist Mono',monospace">{{ $lesson->duration_formatted }}</span>
      </div>
      <h1 style="font-family:'Instrument Serif',serif;font-size:26px;font-weight:400;color:var(--ink);margin-bottom:8px">{{ $lesson->title }}</h1>
      @if($lesson->description)
        <p style="font-size:14px;color:var(--ink2);line-height:1.6;margin-bottom:16px">{{ $lesson->description }}</p>
      @endif

      {{-- PROGRESS BAR --}}
      @if($userProgress)
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 14px;margin-bottom:16px">
          <div style="display:flex;justify-content:space-between;font-size:12px;color:var(--ink3);margin-bottom:6px">
            <span>Your progress</span>
            <span id="progress-pct">{{ $userProgress->percent ?? 0 }}%</span>
          </div>
          <div class="progress-track">
            <div class="progress-fill progress-fill-blue" id="progress-bar" style="width:{{ $userProgress->percent ?? 0 }}%"></div>
          </div>
          @if($userProgress->completed_at)
            <div style="font-size:12px;color:var(--green);margin-top:6px">✓ Completed</div>
          @endif
        </div>
      @endif

      {{-- PROCESS STEPS --}}
      @if($lesson->steps->isNotEmpty())
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:18px 20px">
          <div style="font-size:14px;font-weight:600;color:var(--ink);margin-bottom:14px">Process Steps</div>
          <div style="display:flex;flex-direction:column;gap:10px">
            @foreach($lesson->steps as $step)
              <div style="display:flex;gap:12px">
                <div style="width:24px;height:24px;border-radius:50%;background:var(--accent-light);border:1px solid rgba(59,130,246,0.2);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:var(--accent);flex-shrink:0;margin-top:2px">{{ $loop->iteration }}</div>
                <div>
                  <div style="font-size:13.5px;font-weight:500;color:var(--ink)">{{ $step->title }}</div>
                  @if($step->nav_path)
                    <code style="font-size:11px;color:var(--accent);background:var(--accent-light);padding:2px 8px;border-radius:4px;margin-top:4px;display:inline-block">{{ $step->nav_path }}</code>
                  @endif
                  @if($step->description)
                    <div style="font-size:12px;color:var(--ink3);margin-top:3px">{{ $step->description }}</div>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </div>

    {{-- RIGHT: NAVIGATION --}}
    <div style="display:flex;flex-direction:column;gap:12px;position:sticky;top:80px">
      <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px">
        <div style="font-size:12px;font-weight:600;color:var(--ink3);text-transform:uppercase;letter-spacing:0.07em;margin-bottom:12px">Up Next</div>
        @if($nextLesson)
          <a href="{{ route('academy.lesson', [$package->slug, $nextLesson->slug]) }}" style="display:flex;align-items:center;gap:10px;padding:10px;background:var(--surface2);border:1px solid var(--border2);border-radius:var(--radius-sm);transition:all 0.15s" onmouseover="this.style.borderColor='var(--accent)'" onmouseout="this.style.borderColor='var(--border2)'">
            <div style="width:32px;height:32px;background:var(--accent-light);border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0">▶</div>
            <div style="flex:1;min-width:0">
              <div style="font-size:13px;font-weight:500;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $nextLesson->title }}</div>
              <div style="font-size:11px;color:var(--ink3);font-family:'Geist Mono',monospace">{{ $nextLesson->duration_formatted }}</div>
            </div>
          </a>
        @else
          <div style="font-size:13px;color:var(--ink3);text-align:center;padding:12px">🎉 Last lesson in module!</div>
        @endif
      </div>

      <div style="display:flex;gap:8px">
        @if($prevLesson)
          <a href="{{ route('academy.lesson', [$package->slug, $prevLesson->slug]) }}" class="btn btn-secondary btn-sm" style="flex:1;justify-content:center">← Prev</a>
        @endif
        @if($nextLesson)
          <a href="{{ route('academy.lesson', [$package->slug, $nextLesson->slug]) }}" class="btn btn-primary btn-sm" style="flex:1;justify-content:center">Next →</a>
        @endif
      </div>

      <a href="{{ route('academy.package', $package->slug) }}" style="font-size:12px;color:var(--ink3);text-align:center;display:block">← Back to {{ $package->title }}</a>
    </div>
  </div>
</div>

@if($videoUrl)
<script>
const video = document.getElementById('lesson-video');
const csrfToken = document.querySelector('meta[name=csrf-token]').content;
let lastSaved = 0;
let completed = {{ $userProgress?->completed_at ? 'true' : 'false' }};

// Save progress every 15 seconds while watching
video.addEventListener('timeupdate', function() {
  const current = Math.floor(video.currentTime);
  if (current - lastSaved >= 15) {
    lastSaved = current;
    saveProgress(current);
  }
});

// Mark complete when 90% watched
video.addEventListener('timeupdate', function() {
  if (!completed && video.duration && (video.currentTime / video.duration) >= 0.9) {
    completed = true;
    markComplete();
  }
});

function saveProgress(seconds) {
  fetch('/academy/progress/{{ $lesson->id }}', {
    method: 'POST',
    headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken},
    body: JSON.stringify({watch_seconds: seconds})
  }).then(r => r.json()).then(data => {
    if (data.percent !== undefined) {
      document.getElementById('progress-bar').style.width = data.percent + '%';
      document.getElementById('progress-pct').textContent = data.percent + '%';
    }
  });
}

function markComplete() {
  fetch('/academy/progress/{{ $lesson->id }}/complete', {
    method: 'POST',
    headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken},
    body: JSON.stringify({})
  });
}
</script>
@endif
@endsection
