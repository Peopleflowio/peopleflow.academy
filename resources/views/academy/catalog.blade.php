@extends('layouts.academy')
@section('title', 'Catalog')
@section('topbar-title', 'Course Catalog')
@section('content')
<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:4px">
  <div>
    <h1 style="font-family:'Instrument Serif',serif;font-size:28px;font-weight:400;color:var(--ink)">HCM Process Library</h1>
    <p style="font-size:14px;color:var(--ink3);margin-top:4px">Master every Workday process with guided video lessons</p>
  </div>
</div>
@if($packages->isEmpty())
  <div style="text-align:center;padding:60px 20px;color:var(--ink3)">
    <div style="font-size:40px;margin-bottom:12px">📚</div>
    <div style="font-size:15px;font-weight:600;color:var(--ink2);margin-bottom:6px">No packages available yet</div>
    <div style="font-size:13px">Check back soon</div>
  </div>
@else
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px">
    @foreach($packages as $package)
      @php $enrolled = in_array($package->id, $accessibleIds); @endphp
      <div class="card" style="overflow:hidden;display:flex;flex-direction:column">
        <a href="{{ $enrolled ? route('academy.package', $package->slug) : '#' }}" style="text-decoration:none;display:block">
          <div style="height:130px;background:linear-gradient(135deg,#0f172a,#1e293b);display:flex;align-items:center;justify-content:center;font-size:42px;position:relative">
            {{ $package->emoji_icon }}
            @if($enrolled)
              <span style="position:absolute;top:10px;right:10px" class="badge badge-green"><span class="dot dot-green"></span> Enrolled</span>
            @endif
          </div>
          <div style="padding:16px 16px 8px">
            <div style="font-size:15px;font-weight:600;color:var(--ink);margin-bottom:4px">{{ $package->title }}</div>
            <div style="font-size:12.5px;color:var(--ink3);margin-bottom:12px;line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">{{ $package->description }}</div>
            <div style="font-size:12px;color:var(--ink3)">{{ $package->lesson_count }} lessons</div>
          </div>
        </a>
        <div style="padding:8px 16px 16px;margin-top:auto;display:flex;align-items:center;justify-content:space-between">
          @if($enrolled)
            <span style="font-size:12px;color:var(--ink3)">Already enrolled</span>
            <a href="{{ route('academy.package', $package->slug) }}" class="btn btn-primary btn-sm">Continue →</a>
          @else
            <span style="font-family:'Geist Mono',monospace;font-size:15px;font-weight:600;color:var(--ink)">{{ $package->price_formatted }}</span>
            <a href="{{ route('academy.checkout', $package->slug) }}" class="btn btn-primary btn-sm">Enroll Now →</a>
          @endif
        </div>
      </div>
    @endforeach
  </div>
@endif
@endsection
