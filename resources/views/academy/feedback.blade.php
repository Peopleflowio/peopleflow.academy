@extends('layouts.academy')
@section('title', 'Feedback')
@section('topbar-title', 'Course Feedback')
@section('content')

@if(session('success'))
    <div class="alert-success" style="margin-bottom:16px">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div style="background:#fee2e2;border:1px solid #fecaca;color:#dc2626;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:16px">{{ session('error') }}</div>
@endif

<div style="max-width:700px;margin:0 auto">

    {{-- HEADER --}}
    <div style="background:linear-gradient(135deg,#EEF2FF,#E0E7FF);border:1px solid #c7d2fe;border-radius:14px;padding:28px 32px;margin-bottom:24px">
        <div style="font-size:13px;color:#2563EB;font-weight:600;margin-bottom:6px">💬 Share Your Thoughts</div>
        <h1 style="font-family:'DM Serif Display',serif;font-size:26px;color:#1a1a2e;margin-bottom:8px">Course Feedback</h1>
        <p style="font-size:14px;color:#4a4a6a">Help us improve by sharing your experience with the course.</p>
    </div>

    @if($packages->isEmpty())
        <div class="card card-body" style="text-align:center;padding:40px">
            <div style="font-size:36px;margin-bottom:12px">📚</div>
            <div style="font-size:15px;font-weight:600;color:var(--ink2)">No courses enrolled yet</div>
            <a href="{{ route('academy.catalog') }}" class="btn btn-primary" style="display:inline-flex;margin-top:16px">Browse Courses →</a>
        </div>
    @else
        @foreach($packages as $package)
            <div class="card" style="overflow:hidden;margin-bottom:20px">
                <div style="padding:16px 20px;background:var(--surface2);border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between">
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:24px">{{ $package->emoji_icon }}</span>
                        <div style="font-size:15px;font-weight:600;color:var(--ink)">{{ $package->title }}</div>
                    </div>
                    @if(in_array($package->id, $submitted))
                        <span style="background:#dcfce7;color:#16a34a;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">✓ Submitted</span>
                    @endif
                </div>

                @if(in_array($package->id, $submitted))
                    <div style="padding:20px;text-align:center;color:var(--ink3);font-size:13px">
                        Thank you for your feedback on this course! 🙏
                    </div>
                @else
                    <div style="padding:24px">
                        <form method="POST" action="{{ route('academy.feedback.store') }}">
                            @csrf
                            <input type="hidden" name="package_id" value="{{ $package->id }}">

                            {{-- RATINGS --}}
                            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:20px">
                                @foreach(['rating_overall'=>'Overall Experience','rating_content'=>'Content Quality','rating_platform'=>'Platform Experience'] as $field=>$label)
                                    <div>
                                        <label style="display:block;font-size:12px;font-weight:600;color:var(--ink3);margin-bottom:8px;text-transform:uppercase;letter-spacing:0.06em">{{ $label }}</label>
                                        <div style="display:flex;gap:4px" class="star-group">
                                            @for($i=1;$i<=5;$i++)
                                                <label style="cursor:pointer;font-size:24px;color:#d1d5db;transition:color 0.1s" class="star-label">
                                                    <input type="radio" name="{{ $field }}" value="{{ $i }}" style="display:none" required>
                                                    ★
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- RECOMMEND --}}
                            <div style="margin-bottom:20px">
                                <label style="display:block;font-size:12px;font-weight:600;color:var(--ink3);margin-bottom:8px;text-transform:uppercase;letter-spacing:0.06em">Would you recommend this course?</label>
                                <div style="display:flex;gap:10px">
                                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;padding:8px 16px;border:1.5px solid var(--border);border-radius:8px;font-size:14px">
                                        <input type="radio" name="would_recommend" value="1" required> 👍 Yes
                                    </label>
                                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;padding:8px 16px;border:1.5px solid var(--border);border-radius:8px;font-size:14px">
                                        <input type="radio" name="would_recommend" value="0"> 👎 No
                                    </label>
                                </div>
                            </div>

                            {{-- TEXT FEEDBACK --}}
                            <div style="margin-bottom:16px">
                                <label style="display:block;font-size:12px;font-weight:600;color:var(--ink3);margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em">What did you like most?</label>
                                <textarea name="liked" style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:8px;font-family:inherit;font-size:14px;resize:vertical;min-height:80px;background:var(--bg)" placeholder="Share what you enjoyed..."></textarea>
                            </div>

                            <div style="margin-bottom:16px">
                                <label style="display:block;font-size:12px;font-weight:600;color:var(--ink3);margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em">What could be improved?</label>
                                <textarea name="improve" style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:8px;font-family:inherit;font-size:14px;resize:vertical;min-height:80px;background:var(--bg)" placeholder="Your suggestions..."></textarea>
                            </div>

                            <div style="margin-bottom:20px">
                                <label style="display:block;font-size:12px;font-weight:600;color:var(--ink3);margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em">Any other comments?</label>
                                <textarea name="comments" style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:8px;font-family:inherit;font-size:14px;resize:vertical;min-height:80px;background:var(--bg)" placeholder="Anything else you'd like to share..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">Submit Feedback →</button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    @endif
</div>

<style>
.star-label { color: #d1d5db; }
.star-label:hover,
.star-label:hover ~ .star-label { color: #d1d5db; }
.star-group:hover .star-label { color: #fbbf24; }
.star-group .star-label:hover ~ .star-label { color: #d1d5db; }
input[type=radio]:checked ~ label { color: #fbbf24; }
.star-group input[type=radio]:checked + label,
.star-group input[type=radio]:checked ~ * { color: #fbbf24; }
</style>

<script>
document.querySelectorAll('.star-group').forEach(group => {
    const labels = group.querySelectorAll('.star-label');
    const inputs = group.querySelectorAll('input[type=radio]');
    
    labels.forEach((label, index) => {
        label.addEventListener('mouseover', () => {
            labels.forEach((l, i) => {
                l.style.color = i <= index ? '#fbbf24' : '#d1d5db';
            });
        });
        label.addEventListener('click', () => {
            inputs[index].checked = true;
            labels.forEach((l, i) => {
                l.style.color = i <= index ? '#fbbf24' : '#d1d5db';
            });
        });
    });
    
    group.addEventListener('mouseleave', () => {
        const checked = group.querySelector('input:checked');
        const checkedIndex = checked ? parseInt(checked.value) - 1 : -1;
        labels.forEach((l, i) => {
            l.style.color = i <= checkedIndex ? '#fbbf24' : '#d1d5db';
        });
    });
});
</script>
@endsection
