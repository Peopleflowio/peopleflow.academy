@extends('layouts.academy')
@section('title', 'FAQ')
@section('topbar-title', 'Help & FAQ')
@section('content')

<div style="max-width:800px;margin:0 auto">

    {{-- HEADER --}}
    <div style="background:linear-gradient(135deg,#EEF2FF,#E0E7FF);border:1px solid #c7d2fe;border-radius:14px;padding:28px 32px;margin-bottom:24px">
        <div style="font-size:13px;color:#2563EB;font-weight:600;margin-bottom:6px">❓ Help Centre</div>
        <h1 style="font-family:'DM Serif Display',serif;font-size:26px;color:#1a1a2e;margin-bottom:8px">Frequently Asked Questions</h1>
        <p style="font-size:14px;color:#4a4a6a">Can't find what you're looking for? Email us at <a href="mailto:academy@peopleflow.io" style="color:#2563EB">academy@peopleflow.io</a></p>
    </div>

    {{-- FAQ BY CATEGORY --}}
    @foreach($faqs as $category => $questions)
        <div style="margin-bottom:24px">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#9090a8;margin-bottom:12px;padding-left:4px">{{ $category }}</div>
            <div class="card" style="overflow:hidden">
                @foreach($questions as $i => $faq)
                    <div class="faq-item" style="border-bottom:{{ !$loop->last ? '1px solid var(--border)' : 'none' }}">
                        <button onclick="toggleFaq({{ $faq->id }})" style="width:100%;text-align:left;padding:18px 20px;background:none;border:none;cursor:pointer;display:flex;align-items:center;justify-content:space-between;gap:12px;font-family:inherit">
                            <span style="font-size:14px;font-weight:600;color:var(--ink)">{{ $faq->question }}</span>
                            <span id="icon-{{ $faq->id }}" style="font-size:18px;color:var(--ink3);flex-shrink:0;transition:transform 0.2s">+</span>
                        </button>
                        <div id="answer-{{ $faq->id }}" style="display:none;padding:0 20px 18px;font-size:14px;color:var(--ink2);line-height:1.7">
                            {{ $faq->answer }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    {{-- CONTACT --}}
    <div class="card card-body" style="text-align:center;padding:32px;margin-top:8px">
        <div style="font-size:32px;margin-bottom:12px">📧</div>
        <div style="font-family:'DM Serif Display',serif;font-size:20px;color:var(--ink);margin-bottom:8px">Still need help?</div>
        <div style="font-size:14px;color:var(--ink3);margin-bottom:16px">Our team typically responds within 24 hours</div>
        <a href="mailto:academy@peopleflow.io" class="btn btn-primary" style="display:inline-flex">Email Support →</a>
    </div>
</div>

<script>
function toggleFaq(id) {
    const answer = document.getElementById('answer-' + id);
    const icon = document.getElementById('icon-' + id);
    if (answer.style.display === 'none') {
        answer.style.display = 'block';
        icon.textContent = '−';
        icon.style.color = '#2563EB';
    } else {
        answer.style.display = 'none';
        icon.textContent = '+';
        icon.style.color = '';
    }
}
</script>
@endsection
