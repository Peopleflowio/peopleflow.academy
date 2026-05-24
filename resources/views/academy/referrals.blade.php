@extends('layouts.academy')
@section('title', 'Referrals')
@section('topbar-title', 'Referral Program')
@section('content')

@php
$commissionPercent = \App\Models\Setting::get('referral_commission_percent', 20);
$minReferrals = \App\Models\Setting::get('referral_min_payout', 3);
@endphp

{{-- HERO --}}
<div style="background:linear-gradient(135deg,#EEF2FF,#E0E7FF);border:1px solid #c7d2fe;border-radius:14px;padding:28px 32px;margin-bottom:24px">
    <div style="font-size:13px;color:#2563EB;font-weight:600;margin-bottom:6px">🎁 Referral Program</div>
    <h1 style="font-family:'DM Serif Display',serif;font-size:26px;color:#1a1a2e;margin-bottom:8px">Share & Earn {{ $commissionPercent }}% Commission</h1>
    <p style="font-size:14px;color:#4a4a6a;margin-bottom:20px">Invite colleagues and earn {{ $commissionPercent }}% of their first course purchase. Minimum {{ $minReferrals }} referrals before requesting payout.</p>
    
    {{-- Referral Link --}}
    <div style="background:#fff;border:1px solid #c7d2fe;border-radius:10px;padding:16px 20px;display:flex;align-items:center;gap:12px">
        <div style="flex:1;min-width:0">
            <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;color:#9090a8;margin-bottom:4px">Your Referral Link</div>
            <div style="font-size:14px;color:#1a1a2e;font-family:monospace;white-space:nowrap;overflow:hidden;text-overflow:ellipsis" id="refLink">{{ $referralLink }}</div>
        </div>
        <button onclick="copyLink()" style="background:#2563EB;color:#fff;border:none;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap;font-family:inherit" id="copyBtn">Copy Link</button>
    </div>

    <div style="margin-top:12px;display:flex;align-items:center;gap:10px">
        <span style="font-size:13px;color:#4a4a6a">Your code:</span>
        <span style="background:#fff;border:1px solid #c7d2fe;padding:4px 14px;border-radius:6px;font-family:monospace;font-size:15px;font-weight:700;color:#2563EB;letter-spacing:0.1em">{{ $referralCode }}</span>
    </div>
</div>

{{-- STATS --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px">
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
    <div class="card card-body" style="text-align:center">
        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:8px">Pending Payout</div>
        <div style="font-family:'DM Serif Display',serif;font-size:36px;color:#d97706">${{ number_format($pendingPayout/100, 2) }}</div>
    </div>
</div>

{{-- PAYOUT REQUEST --}}
@php 
    $hasPendingPayout = $payoutRequests->where('status','pending')->count() > 0;
    $paidOut = $payoutRequests->where('status','paid')->sum('amount_cents');
    $availableBalance = max(0, $totalEarned - $paidOut);
@endphp
@if($converted >= $minReferrals && $availableBalance > 0 && !$hasPendingPayout)
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:20px 24px;margin-bottom:24px;display:flex;align-items:center;justify-content:space-between">
        <div>
            <div style="font-size:14px;font-weight:600;color:#16a34a;margin-bottom:4px">🎉 You're eligible for a payout!</div>
            <div style="font-size:13px;color:#4a4a6a">You have ${{ number_format($availableBalance/100, 2) }} available to withdraw</div>
        </div>
        <button onclick="document.getElementById('payoutModal').style.display='flex'" style="background:#16a34a;color:#fff;border:none;padding:10px 20px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit">Request Payout →</button>
    </div>
@elseif($converted < $minReferrals)
    <div style="background:#fefce8;border:1px solid #fde68a;border-radius:12px;padding:16px 20px;margin-bottom:24px">
        <div style="font-size:13px;color:#92400e">⚠️ You need <strong>{{ $minReferrals - $converted }} more converted referral(s)</strong> before requesting a payout (minimum {{ $minReferrals }} required)</div>
    </div>
@endif

{{-- PAYOUT HISTORY --}}
@if($payoutRequests->count() > 0)
<div class="card" style="overflow:hidden;margin-bottom:24px">
    <div style="padding:16px 20px;border-bottom:1px solid var(--border)">
        <div style="font-size:14px;font-weight:600;color:var(--ink)">Payout History</div>
    </div>
    @foreach($payoutRequests as $payout)
        <div style="display:flex;align-items:center;gap:14px;padding:14px 20px;border-bottom:1px solid var(--border)">
            <div style="flex:1">
                <div style="font-size:14px;font-weight:500;color:var(--ink)">${{ number_format($payout->amount_cents/100, 2) }}</div>
                <div style="font-size:12px;color:var(--ink3)">{{ $payout->created_at->format('d M Y') }} · {{ $payout->payment_method }}</div>
            </div>
            <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;
                {{ $payout->status === 'paid' ? 'background:#dcfce7;color:#16a34a' : ($payout->status === 'rejected' ? 'background:#fee2e2;color:#dc2626' : 'background:#fef9c3;color:#ca8a04') }}">
                {{ ucfirst($payout->status) }}
            </span>
        </div>
    @endforeach
</div>
@endif

{{-- REFERRALS LIST --}}
<div class="card" style="overflow:hidden">
    <div style="padding:16px 20px;border-bottom:1px solid var(--border)">
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
        <div style="font-size:14px;font-weight:600;color:var(--ink);margin-bottom:6px">They Buy a Course</div>
        <div style="font-size:13px;color:var(--ink3)">Earn {{ $commissionPercent }}% when they make their first purchase</div>
    </div>
    <div class="card card-body" style="text-align:center">
        <div style="font-size:32px;margin-bottom:12px">💰</div>
        <div style="font-size:14px;font-weight:600;color:var(--ink);margin-bottom:6px">Request Payout</div>
        <div style="font-size:13px;color:var(--ink3)">After {{ $minReferrals }} conversions request your earnings</div>
    </div>
</div>

{{-- PAYOUT MODAL --}}
<div id="payoutModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:1000;align-items:center;justify-content:center">
    <div style="background:#fff;border-radius:14px;padding:32px;width:100%;max-width:480px;margin:20px">
        <h2 style="font-family:'DM Serif Display',serif;font-size:22px;color:#1a1a2e;margin-bottom:6px">Request Payout</h2>
        <p style="font-size:13px;color:#9090a8;margin-bottom:24px">Amount: <strong>${{ number_format($totalEarned/100, 2) }}</strong></p>
        <form method="POST" action="{{ route('academy.referrals.payout') }}">
            @csrf
            <div style="margin-bottom:16px">
                <label style="display:block;font-size:12px;font-weight:600;color:#4a4a6a;margin-bottom:6px">Payment Method</label>
                <select name="payment_method" style="width:100%;padding:10px 14px;border:1px solid #e8e6e1;border-radius:8px;font-family:inherit;font-size:14px" required>
                    <option value="">Select...</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="paypal">PayPal</option>
                    <option value="wise">Wise</option>
                </select>
            </div>
            <div style="margin-bottom:16px">
                <label style="display:block;font-size:12px;font-weight:600;color:#4a4a6a;margin-bottom:6px">Payment Details</label>
                <input type="text" name="payment_details" style="width:100%;padding:10px 14px;border:1px solid #e8e6e1;border-radius:8px;font-family:inherit;font-size:14px" placeholder="Account number / email / etc" required>
            </div>
            <div style="display:flex;gap:10px;margin-top:24px">
                <button type="submit" style="flex:1;padding:12px;background:#2563EB;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit">Submit Request</button>
                <button type="button" onclick="document.getElementById('payoutModal').style.display='none'" style="flex:1;padding:12px;background:#f5f4f0;color:#1a1a2e;border:1px solid #e8e6e1;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit">Cancel</button>
            </div>
        </form>
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
