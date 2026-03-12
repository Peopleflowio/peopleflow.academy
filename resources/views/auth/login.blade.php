<x-guest-layout>
<div class="auth-title">Welcome back</div>
<div class="auth-subtitle">Sign in to your Peopleflow Academy account</div>

<x-auth-session-status class="status-msg" :status="session('status')" />

<form method="POST" action="{{ route('login') }}">
  @csrf
  <div class="form-group">
    <label>Email Address</label>
    <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
    @error('email')<div class="error-msg">{{ $message }}</div>@enderror
  </div>
  <div class="form-group">
    <label>Password</label>
    <input type="password" name="password" required autocomplete="current-password">
    @error('password')<div class="error-msg">{{ $message }}</div>@enderror
  </div>
  <div class="auth-links">
    <label class="remember">
      <input type="checkbox" name="remember">
      Remember me
    </label>
    @if (Route::has('password.request'))
      <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
    @endif
  </div>
  <button type="submit" class="btn-submit">Sign In</button>
</form>
<div class="auth-footer">
  Don't have an account? <a href="{{ route('register') }}">Create one free</a>
</div>
</x-guest-layout>
