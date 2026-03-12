<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body { font-family: Inter, sans-serif; background: #f4f4f5; margin: 0; padding: 40px 20px; }
    .container { max-width: 560px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; }
    .header { background: #050508; padding: 32px; text-align: center; }
    .header img { height: 32px; }
    .header-title { color: #005edb; font-size: 13px; font-weight: 600; letter-spacing: 0.05em; margin-top: 12px; }
    .body { padding: 32px; }
    .title { font-size: 22px; font-weight: 700; color: #111; margin-bottom: 8px; }
    .subtitle { font-size: 15px; color: #555; margin-bottom: 24px; line-height: 1.6; }
    .course-card { background: #f8f8fa; border-radius: 8px; padding: 16px 20px; margin-bottom: 24px; border-left: 3px solid #005edb; }
    .course-name { font-size: 16px; font-weight: 600; color: #111; }
    .course-meta { font-size: 13px; color: #777; margin-top: 4px; }
    .btn { display: inline-block; background: #005edb; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; margin-bottom: 24px; }
    .footer { padding: 20px 32px; background: #f8f8fa; font-size: 12px; color: #999; text-align: center; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <div style="color:white;font-size:20px;font-weight:700">Peopleflow <span style="color:#005edb">Academy</span></div>
      <div class="header-title">ENROLLMENT CONFIRMED</div>
    </div>
    <div class="body">
      <div class="title">You're in, {{ $user->name }}! 🎉</div>
      <div class="subtitle">Your enrollment has been confirmed and your course is ready to start. Jump in whenever you're ready.</div>
      <div class="course-card">
        <div class="course-name">{{ $package->title }}</div>
        <div class="course-meta">Lifetime access · Self-paced</div>
      </div>
      <a href="{{ url('/academy') }}" class="btn">Start Learning →</a>
      <div style="font-size:13px;color:#777;line-height:1.6">
        If you have any questions, just reply to this email — we're happy to help.<br><br>
        The Peopleflow Academy Team
      </div>
    </div>
    <div class="footer">
      © {{ date('Y') }} Peopleflow Academy · <a href="{{ url('/') }}" style="color:#999">peopleflow.io</a>
    </div>
  </div>
</body>
</html>
