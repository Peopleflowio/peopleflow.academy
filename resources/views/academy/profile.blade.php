@extends('layouts.academy')
@section('title', 'Profile')
@section('topbar-title', 'My Profile')
@section('content')
<div style="max-width:640px">

  @if(session('success'))
    <div style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#22c55e">
      ✓ {{ session('success') }}
    </div>
  @endif

  <div class="form-card" style="margin-bottom:16px">
    <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;padding-bottom:20px;border-bottom:1px solid var(--border)">
      <div style="width:56px;height:56px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:700;color:white;flex-shrink:0">
        {{ strtoupper(substr($user->name, 0, 2)) }}
      </div>
      <div>
        <div style="font-size:16px;font-weight:600;color:var(--ink)">{{ $user->name }}</div>
        <div style="font-size:13px;color:var(--ink3)">{{ $user->email }}</div>
        <div style="font-size:11px;color:var(--ink3);margin-top:2px">Member since {{ $user->created_at->format("M Y") }}</div>
      </div>
    </div>
    <form method="POST" action="{{ route('academy.profile.update') }}">
      @csrf @method('PUT')
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px">
        <div>
          <label style="font-size:12px;font-weight:500;color:var(--ink2);display:block;margin-bottom:6px">Full Name</label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}"
            style="width:100%;padding:9px 12px;background:var(--bg);border:1px solid var(--border);border-radius:6px;font-size:13px;color:var(--ink);font-family:inherit;box-sizing:border-box">
          @error('name')<div style="font-size:11px;color:#ef4444;margin-top:4px">{{ $message }}</div>@enderror
        </div>
        <div>
          <label style="font-size:12px;font-weight:500;color:var(--ink2);display:block;margin-bottom:6px">Email Address</label>
          <input type="email" name="email" value="{{ old('email', $user->email) }}"
            style="width:100%;padding:9px 12px;background:var(--bg);border:1px solid var(--border);border-radius:6px;font-size:13px;color:var(--ink);font-family:inherit;box-sizing:border-box">
          @error('email')<div style="font-size:11px;color:#ef4444;margin-top:4px">{{ $message }}</div>@enderror
        </div>
      </div>
      <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
    </form>
  </div>

  <div class="form-card">
    <div style="font-size:14px;font-weight:600;color:var(--ink);margin-bottom:16px">Change Password</div>
    <form method="POST" action="{{ route('academy.profile.password') }}">
      @csrf @method('PUT')
      <div style="display:flex;flex-direction:column;gap:14px;margin-bottom:16px">
        <div>
          <label style="font-size:12px;font-weight:500;color:var(--ink2);display:block;margin-bottom:6px">Current Password</label>
          <input type="password" name="current_password"
            style="width:100%;padding:9px 12px;background:var(--bg);border:1px solid var(--border);border-radius:6px;font-size:13px;color:var(--ink);font-family:inherit;box-sizing:border-box">
          @error('current_password')<div style="font-size:11px;color:#ef4444;margin-top:4px">{{ $message }}</div>@enderror
        </div>
        <div>
          <label style="font-size:12px;font-weight:500;color:var(--ink2);display:block;margin-bottom:6px">New Password</label>
          <input type="password" name="password"
            style="width:100%;padding:9px 12px;background:var(--bg);border:1px solid var(--border);border-radius:6px;font-size:13px;color:var(--ink);font-family:inherit;box-sizing:border-box">
          @error('password')<div style="font-size:11px;color:#ef4444;margin-top:4px">{{ $message }}</div>@enderror
        </div>
        <div>
          <label style="font-size:12px;font-weight:500;color:var(--ink2);display:block;margin-bottom:6px">Confirm New Password</label>
          <input type="password" name="password_confirmation"
            style="width:100%;padding:9px 12px;background:var(--bg);border:1px solid var(--border);border-radius:6px;font-size:13px;color:var(--ink);font-family:inherit;box-sizing:border-box">
        </div>
      </div>
      <button type="submit" class="btn btn-primary btn-sm">Update Password</button>
    </form>
  </div>

</div>
@endsection
