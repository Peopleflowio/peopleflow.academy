@extends('layouts.admin')
@section('title', 'Feedback')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Course Feedback</h1>
        <p class="page-sub">{{ $feedback->count() }} responses collected</p>
    </div>
</div>

{{-- STATS --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px">
    <div class="card card-body" style="text-align:center">
        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:8px">Overall Rating</div>
        <div style="font-size:32px;font-weight:700;color:var(--accent)">{{ number_format($avgOverall, 1) }} ⭐</div>
    </div>
    <div class="card card-body" style="text-align:center">
        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:8px">Content Quality</div>
        <div style="font-size:32px;font-weight:700;color:var(--accent)">{{ number_format($avgContent, 1) }} ⭐</div>
    </div>
    <div class="card card-body" style="text-align:center">
        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:8px">Platform Rating</div>
        <div style="font-size:32px;font-weight:700;color:var(--accent)">{{ number_format($avgPlatform, 1) }} ⭐</div>
    </div>
    <div class="card card-body" style="text-align:center">
        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:8px">Would Recommend</div>
        <div style="font-size:32px;font-weight:700;color:#16a34a">{{ $recommended }}/{{ $feedback->count() }}</div>
    </div>
</div>

{{-- FEEDBACK LIST --}}
@forelse($feedback as $fb)
    <div class="card card-body" style="margin-bottom:12px">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px">
            <div>
                <div style="font-size:14px;font-weight:600;color:var(--ink)">{{ $fb->user->name }}</div>
                <div style="font-size:12px;color:var(--ink3)">{{ $fb->package?->title }} · {{ $fb->created_at->format('d M Y') }}</div>
            </div>
            <span style="background:{{ $fb->would_recommend ? '#dcfce7' : '#fee2e2' }};color:{{ $fb->would_recommend ? '#16a34a' : '#dc2626' }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                {{ $fb->would_recommend ? '👍 Recommends' : '👎 Does not recommend' }}
            </span>
        </div>
        <div style="display:flex;gap:20px;margin-bottom:12px">
            <div style="font-size:13px;color:var(--ink2)">Overall: <strong>{{ $fb->rating_overall }}/5 ⭐</strong></div>
            <div style="font-size:13px;color:var(--ink2)">Content: <strong>{{ $fb->rating_content }}/5 ⭐</strong></div>
            <div style="font-size:13px;color:var(--ink2)">Platform: <strong>{{ $fb->rating_platform }}/5 ⭐</strong></div>
        </div>
        @if($fb->liked)
            <div style="margin-bottom:8px"><span style="font-size:11px;font-weight:600;color:var(--ink3)">LIKED: </span><span style="font-size:13px;color:var(--ink)">{{ $fb->liked }}</span></div>
        @endif
        @if($fb->improve)
            <div style="margin-bottom:8px"><span style="font-size:11px;font-weight:600;color:var(--ink3)">IMPROVE: </span><span style="font-size:13px;color:var(--ink)">{{ $fb->improve }}</span></div>
        @endif
        @if($fb->comments)
            <div><span style="font-size:11px;font-weight:600;color:var(--ink3)">COMMENTS: </span><span style="font-size:13px;color:var(--ink)">{{ $fb->comments }}</span></div>
        @endif
    </div>
@empty
    <div class="card card-body" style="text-align:center;color:var(--ink3)">No feedback yet</div>
@endforelse
@endsection
