<x-guest-layout>
<div class="auth-title">Create your account</div>
<div class="auth-subtitle">Join Peopleflow Academy and start learning today</div>

<form method="POST" action="{{ route('register') }}">
  @csrf
  <div class="form-group">
    <label>Full Name</label>
    <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
    @error('name')<div class="error-msg">{{ $message }}</div>@enderror
  </div>
  <div class="form-group">
    <label>Email Address</label>
    <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
    @error('email')<div class="error-msg">{{ $message }}</div>@enderror
  </div>
  <div class="form-group">
    <label>Password</label>
    <input type="password" name="password" required autocomplete="new-password">
    @error('password')<div class="error-msg">{{ $message }}</div>@enderror
  </div>
  <div class="form-group">
    <label>Confirm Password</label>
    <input type="password" name="password_confirmation" required autocomplete="new-password">
  </div>
  <button type="submit" class="btn-submit">Create Account</button>
</form>
<div class="auth-footer">
  Already have an account? <a href="{{ route('login') }}">Sign in</a>
</div>
</x-guest-layout>
