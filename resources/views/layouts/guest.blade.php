<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Peopleflow Academy') }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Inter', sans-serif; background: #050508; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
    .auth-container { width: 100%; max-width: 440px; }
    .auth-logo { text-align: center; margin-bottom: 32px; }
    .auth-logo a { text-decoration: none; display: inline-flex; align-items: center; gap: 10px; }
    .auth-logo img { height: 28px; }
    .auth-logo-text { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; color: #005edb; }
    .auth-card { background: #0f1117; border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 36px; }
    .auth-title { font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 700; color: #fff; margin-bottom: 6px; }
    .auth-subtitle { font-size: 13px; color: rgba(255,255,255,0.4); margin-bottom: 28px; }
    .form-group { margin-bottom: 18px; }
    label { display: block; font-size: 12px; font-weight: 500; color: rgba(255,255,255,0.6); margin-bottom: 6px; }
    input[type=email], input[type=password], input[type=text] {
      width: 100%; padding: 10px 14px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
      border-radius: 8px; font-size: 14px; color: #fff; font-family: inherit; outline: none; transition: border 0.2s;
    }
    input:focus { border-color: #005edb; }
    .btn-submit { width: 100%; padding: 12px; background: #005edb; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: inherit; transition: background 0.2s; margin-top: 8px; }
    .btn-submit:hover { background: #0052c4; }
    .auth-footer { margin-top: 20px; text-align: center; font-size: 13px; color: rgba(255,255,255,0.4); }
    .auth-footer a { color: #005edb; text-decoration: none; }
    .auth-links { display: flex; justify-content: space-between; align-items: center; margin-top: 16px; }
    .auth-link { font-size: 13px; color: rgba(255,255,255,0.4); text-decoration: none; }
    .auth-link:hover { color: #fff; }
    .remember { display: flex; align-items: center; gap: 8px; font-size: 13px; color: rgba(255,255,255,0.5); }
    .remember input { width: auto; }
    .error-msg { font-size: 12px; color: #ef4444; margin-top: 4px; }
    .status-msg { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3); border-radius: 6px; padding: 10px 14px; font-size: 13px; color: #22c55e; margin-bottom: 16px; }
  </style>
</head>
<body>
  <div class="auth-container">
    <div class="auth-logo">
      <a href="{{ route('home') }}">
        <img src="/images/peopleflow-logo.avif" alt="Peopleflow">
        <span class="auth-logo-text">Academy</span>
      </a>
    </div>
    <div class="auth-card">
      {{ $slot }}
    </div>
  </div>
</body>
</html>
