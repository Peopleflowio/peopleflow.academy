@extends('layouts.academy')
@section('title', 'Referrals')
@section('topbar-title', 'Referral Program')
@section('content')

{{-- HERO --}}
<div style="background:linear-gradient(135deg,#EEF2FF,#E0E7FF);border:1px solid #c7d2fe;border-radius:14px;padding:28px 32px;margin-bottom:24px">
    <div style="font-size:13px;color:#2563EB;font-weight:600;margin-bottom:6px">🎁 Referral Program</div>
    <h1 style="font-family:'DM Serif Display',serif;font-size:26px;color:#1a1a2e;margin-bottom:8px">Share & Earn</h1>
    <p style="font-size:14px;color:#4a4a6a;margin-bottom:20px">Invite colleagues to Peopleflow Academy and earn rewards when they enroll.</p>
    
    {{-- Referral Link --}}
    <div style="background:#fff;border:1px solid #c7d2fe;border-radius:10px;padding:16px 20px;display:flex;align-items:center;gap:12px">
        <div style="flex:1;min-width:0">
            <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;color:#9090a8;margin-bottom:4px">Your Referral Link</div>
            <div style="font-size:14px;color:#1a1a2e;font-family:monospace;white-space:nowrap;overflow:hidden;text-overflow:ellipsis" id="refLink">{{ $referralLink }}</div>
        </div>
        <button onclick="copyLink()" style="background:#2563EB;color:#fff;border:none;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap;font-family:inherit" id="copyBtn">Copy Link</button>
    </div>

    {{-- Referral Code --}}
    <div style="margin-top:12px;display:flex;align-items:center;gap:10px">
        <span style="font-size:13px;color:#4a4a6a">Your code:</span>
        <span style="background:#fff;border:1px solid #c7d2fe;padding:4px 14px;border-radius:6px;font-family:monospace;font-size:15px;font-weight:700;color:#2563EB;letter-spacing:0.1em">{{ $referralCode }}</span>
    </div>
</div>

{{-- STATS --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px">
    <div class="card card-body" style="text-align:center">
        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:8px">Total Referrals</div>
        <div style="font-family:'DM Serif Display',serif;font-size:36px;color:var(--ink)">{{ $totalReferrals }}</div>
    </div>
    <div class="card card-body" style="text-align:center">
        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:8px">Converted</div>
        <div style="font-family:'DM Serif Display',serif;font-size:36px;color:#16a34a">{{ $converted }}</div>
    </div>
    <div class="card card-body" style="text-align:center">
        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:8px">Total Earned</div>
        <div style="font-family:'DM Serif Display',serif;font-size:36px;color:#2563EB">${{ number_format($totalEarned/100, 2) }}</div>
    </div>
</div>

{{-- REFERRALS LIST --}}
<div class="card" style="overflow:hidden">
    <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between">
        <div style="font-size:14px;font-weight:600;color:var(--ink)">Your Referrals</div>
    </div>
    @forelse($referrals as $referral)
        <div style="display:flex;align-items:center;gap:14px;padding:14px 20px;border-bottom:1px solid var(--border)">
            <div style="width:36px;height:36px;border-radius:50%;background:var(--accent-light);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:var(--accent);flex-shrink:0">
                {{ strtoupper(substr($referral->referred->name, 0, 2)) }}
            </div>
            <div style="flex:1">
                <div style="font-size:14px;font-weight:500;color:var(--ink)">{{ $referral->referred->name }}</div>
                <div style="font-size:12px;color:var(--ink3)">{{ $referral->created_at->format('d M Y') }}</div>
            </div>
            <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;{{ $referral->status === 'converted' ? 'background:#dcfce7;color:#16a34a' : 'background:#fef9c3;color:#ca8a04' }}">
                {{ ucfirst($referral->status) }}
            </span>
            @if($referral->reward_cents > 0)
                <div style="font-size:13px;font-weight:600;color:#16a34a">+${{ number_format($referral->reward_cents/100, 2) }}</div>
            @endif
        </div>
    @empty
        <div style="padding:40px;text-align:center;color:var(--ink3)">
            <div style="font-size:36px;margin-bottom:12px">🤝</div>
            <div style="font-size:15px;font-weight:600;color:var(--ink2);margin-bottom:6px">No referrals yet</div>
            <div style="font-size:13px">Share your link to start earning!</div>
        </div>
    @endforelse
</div>

{{-- HOW IT WORKS --}}
<div style="margin-top:24px;display:grid;grid-template-columns:repeat(3,1fr);gap:16px">
    <div class="card card-body" style="text-align:center">
        <div style="font-size:32px;margin-bottom:12px">🔗</div>
        <div style="font-size:14px;font-weight:600;color:var(--ink);margin-bottom:6px">Share Your Link</div>
        <div style="font-size:13px;color:var(--ink3)">Send your unique referral link to colleagues</div>
    </div>
    <div class="card card-body" style="text-align:center">
        <div style="font-size:32px;margin-bottom:12px">📝</div>
        <div style="font-size:14px;font-weight:600;color:var(--ink);margin-bottom:6px">They Sign Up</div>
        <div style="font-size:13px;color:var(--ink3)">Your colleague registers using your link</div>
    </div>
    <div class="card card-body" style="text-align:center">
        <div style="font-size:32px;margin-bottom:12px">💰</div>
        <div style="font-size:14px;font-weight:600;color:var(--ink);margin-bottom:6px">You Earn</div>
        <div style="font-size:13px;color:var(--ink3)">Earn rewards when they purchase a course</div>
    </div>
</div>

<script>
function copyLink() {
    navigator.clipboard.writeText('{{ $referralLink }}');
    document.getElementById('copyBtn').textContent = 'Copied!';
    setTimeout(() => document.getElementById('copyBtn').textContent = 'Copy Link', 2000);
}
</script>
@endsection
