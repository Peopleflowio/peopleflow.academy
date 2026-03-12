@extends('layouts.admin')
@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')
@section('content')

<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px">
  <div class="form-card" style="display:flex;align-items:center;gap:14px">
    <div style="width:44px;height:44px;border-radius:10px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;font-size:20px">👥</div>
    <div>
      <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:4px">Total Learners</div>
      <div style="font-family:'Instrument Serif',serif;font-size:28px;color:var(--ink);line-height:1">{{ $totalUsers }}</div>
    </div>
  </div>
  <div class="form-card" style="display:flex;align-items:center;gap:14px">
    <div style="width:44px;height:44px;border-radius:10px;background:#f0f9ff;display:flex;align-items:center;justify-content:center;font-size:20px">💰</div>
    <div>
      <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:4px">Total Revenue</div>
      <div style="font-family:'Instrument Serif',serif;font-size:28px;color:var(--ink);line-height:1">${{ number_format($totalRevenue / 100, 2) }}</div>
    </div>
  </div>
  <div class="form-card" style="display:flex;align-items:center;gap:14px">
    <div style="width:44px;height:44px;border-radius:10px;background:#fefce8;display:flex;align-items:center;justify-content:center;font-size:20px">🛒</div>
    <div>
      <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:4px">Purchases</div>
      <div style="font-family:'Instrument Serif',serif;font-size:28px;color:var(--ink);line-height:1">{{ $totalPurchases }}</div>
    </div>
  </div>
  <div class="form-card" style="display:flex;align-items:center;gap:14px">
    <div style="width:44px;height:44px;border-radius:10px;background:#fdf4ff;display:flex;align-items:center;justify-content:center;font-size:20px">🎯</div>
    <div>
      <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:4px">Active Today</div>
      <div style="font-family:'Instrument Serif',serif;font-size:28px;color:var(--ink);line-height:1">{{ $activeToday }}</div>
    </div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">
  <div class="form-card">
    <div style="font-size:14px;font-weight:600;color:var(--ink);margin-bottom:14px">Recent Purchases</div>
    @forelse($recentPurchases as $purchase)
      <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--border)">
        <div style="width:36px;height:36px;border-radius:50%;background:var(--accent-light);display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:var(--accent);flex-shrink:0">
          {{ strtoupper(substr($purchase->organization?->name ?? '?', 0, 1)) }}
        </div>
        <div style="flex:1;min-width:0">
          <div style="font-size:13px;font-weight:500;color:var(--ink)">{{ $purchase->organization?->name ?? 'Unknown' }}</div>
          <div style="font-size:11px;color:var(--ink3)">{{ $purchase->package?->title }} · {{ $purchase->seat_count }} seat{{ $purchase->seat_count > 1 ? 's' : '' }}</div>
        </div>
        <div style="text-align:right;flex-shrink:0">
          <div style="font-size:13px;font-weight:600;color:var(--ink);font-family:'Geist Mono',monospace">${{ number_format($purchase->amount_cents / 100, 2) }}</div>
          <div style="font-size:11px;color:var(--ink3)">{{ $purchase->paid_at?->diffForHumans() }}</div>
        </div>
      </div>
    @empty
      <div style="text-align:center;padding:20px;color:var(--ink3);font-size:13px">No purchases yet</div>
    @endforelse
  </div>

  <div class="form-card">
    <div style="font-size:14px;font-weight:600;color:var(--ink);margin-bottom:14px">Package Performance</div>
    @foreach($packages as $pkg)
      <div style="padding:10px 0;border-bottom:1px solid var(--border)">
        <div style="display:flex;align-items:center;justify-content:space-between">
          <div style="display:flex;align-items:center;gap:8px">
            <span style="font-size:18px">{{ $pkg->emoji_icon }}</span>
            <div>
              <div style="font-size:13px;font-weight:500;color:var(--ink)">{{ $pkg->title }}</div>
              <div style="font-size:11px;color:var(--ink3)">{{ $pkg->seat_count }} enrolled · {{ $pkg->lessons_count }} lessons</div>
            </div>
          </div>
          <div style="text-align:right">
            <div style="font-size:13px;font-weight:600;color:var(--green);font-family:'Geist Mono',monospace">${{ number_format($pkg->revenue / 100, 2) }}</div>
            <span class="badge {{ $pkg->is_published ? 'badge-green' : 'badge-amber' }}">{{ $pkg->is_published ? 'Live' : 'Draft' }}</span>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

<div class="form-card">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
    <div style="font-size:14px;font-weight:600;color:var(--ink)">All Learners</div>
    <span style="font-size:12px;color:var(--ink3)">{{ $totalUsers }} total</span>
  </div>
  <table style="width:100%;border-collapse:collapse">
    <thead>
      <tr style="border-bottom:1px solid var(--border)">
        <th style="text-align:left;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);padding:8px 0">User</th>
        <th style="text-align:left;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);padding:8px 0">Organisation</th>
        <th style="text-align:left;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);padding:8px 0">Enrolled</th>
        <th style="text-align:left;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);padding:8px 0">Joined</th>
        <th style="text-align:left;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);padding:8px 0">Last Active</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $user)
        @php
          $userSeats = \App\Models\SeatLicense::where('user_id', $user->id)->whereNull('revoked_at')->with('package')->get();
          $lastActive = \App\Models\LessonProgress::where('user_id', $user->id)->latest('updated_at')->first();
        @endphp
        <tr style="border-bottom:1px solid var(--border)">
          <td style="padding:10px 0">
            <div style="display:flex;align-items:center;gap:8px">
              <div style="width:30px;height:30px;border-radius:50%;background:var(--accent-light);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:var(--accent)">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
              <div>
                <div style="font-size:13px;font-weight:500;color:var(--ink)">{{ $user->name }}</div>
                <div style="font-size:11px;color:var(--ink3)">{{ $user->email }}</div>
              </div>
            </div>
          </td>
          <td style="padding:10px 0;font-size:13px;color:var(--ink2)">{{ $user->organization?->name ?? '—' }}</td>
          <td style="padding:10px 0">
            @if($userSeats->isEmpty())
              <span style="font-size:12px;color:var(--ink3)">None</span>
            @else
              <div style="display:flex;flex-wrap:wrap;gap:4px">
                @foreach($userSeats as $seat)
                  <span class="badge badge-blue">{{ $seat->package?->title }}</span>
                @endforeach
              </div>
            @endif
          </td>
          <td style="padding:10px 0;font-size:12px;color:var(--ink3)">{{ $user->created_at->format('d M Y') }}</td>
          <td style="padding:10px 0;font-size:12px;color:var(--ink3)">{{ $lastActive?->updated_at->diffForHumans() ?? 'Never' }}</td>
        </tr>
      @empty
        <tr><td colspan="5" style="padding:20px;text-align:center;color:var(--ink3);font-size:13px">No learners yet</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
