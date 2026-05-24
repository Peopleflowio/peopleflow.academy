@extends('layouts.admin')
@section('title', 'Settings & Payouts')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Settings & Payouts</h1>
        <p class="page-sub">Manage referral settings and payout requests</p>
    </div>
</div>

@if(session('success'))
    <div class="alert-success" style="margin-bottom:16px">{{ session('success') }}</div>
@endif

<div style="display:grid;grid-template-columns:1fr 2fr;gap:24px;align-items:start">

{{-- SETTINGS --}}
<div class="card card-body">
    <h2 style="font-size:15px;font-weight:600;margin-bottom:16px">Referral Settings</h2>
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf @method('PATCH')
        <div class="field">
            <label class="lbl">Commission % on First Purchase</label>
            <input type="number" name="settings[referral_commission_percent]" class="inp" value="{{ $settings['referral_commission_percent']->value ?? 20 }}" min="1" max="100" required>
            <div style="font-size:11px;color:var(--ink3);margin-top:4px">{{ $settings['referral_commission_percent']->description ?? '' }}</div>
        </div>
        <div class="field">
            <label class="lbl">Minimum Referrals for Payout</label>
            <input type="number" name="settings[referral_min_payout]" class="inp" value="{{ $settings['referral_min_payout']->value ?? 3 }}" min="1" required>
            <div style="font-size:11px;color:var(--ink3);margin-top:4px">{{ $settings['referral_min_payout']->description ?? '' }}</div>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Save Settings</button>
    </form>
</div>

{{-- PAYOUT REQUESTS --}}
<div>
    <h2 style="font-size:15px;font-weight:600;margin-bottom:16px">Payout Requests</h2>
    @forelse($payouts as $payout)
        <div class="card card-body" style="margin-bottom:12px">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px">
                <div>
                    <div style="font-size:15px;font-weight:600;color:var(--ink)">{{ $payout->user->name }}</div>
                    <div style="font-size:12px;color:var(--ink3);margin-top:2px">{{ $payout->user->email }}</div>
                    <div style="margin-top:8px;display:flex;gap:12px">
                        <div>
                            <div style="font-size:11px;color:var(--ink3)">Amount</div>
                            <div style="font-size:15px;font-weight:700;color:#16a34a">${{ number_format($payout->amount_cents/100, 2) }}</div>
                        </div>
                        <div>
                            <div style="font-size:11px;color:var(--ink3)">Method</div>
                            <div style="font-size:13px;color:var(--ink)">{{ ucfirst(str_replace('_',' ',$payout->payment_method)) }}</div>
                        </div>
                        <div>
                            <div style="font-size:11px;color:var(--ink3)">Details</div>
                            <div style="font-size:13px;color:var(--ink)">{{ $payout->payment_details }}</div>
                        </div>
                        <div>
                            <div style="font-size:11px;color:var(--ink3)">Requested</div>
                            <div style="font-size:13px;color:var(--ink)">{{ $payout->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.settings.payout', $payout) }}" style="min-width:200px">
                    @csrf @method('PATCH')
                    <select name="status" class="sel" style="margin-bottom:8px">
                        <option value="pending" {{ $payout->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $payout->status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="rejected" {{ $payout->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <input type="text" name="notes" class="inp" placeholder="Notes (optional)" value="{{ $payout->notes }}" style="margin-bottom:8px">
                    <button type="submit" class="btn btn-primary btn-sm" style="width:100%">Update</button>
                </form>
            </div>
            <div style="margin-top:8px">
                <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;
                    {{ $payout->status === 'paid' ? 'background:#dcfce7;color:#16a34a' : ($payout->status === 'rejected' ? 'background:#fee2e2;color:#dc2626' : 'background:#fef9c3;color:#ca8a04') }}">
                    {{ ucfirst($payout->status) }}
                </span>
            </div>
        </div>
    @empty
        <div class="card card-body" style="text-align:center;color:var(--ink3)">No payout requests yet</div>
    @endforelse
</div>
</div>
@endsection
