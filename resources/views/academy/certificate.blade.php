<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Certificate — {{ $package->title }}</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F5F4F0; min-height: 100vh; padding: 40px 20px; }
    .back { display: inline-flex; align-items: center; gap: 6px; color: #2563EB; text-decoration: none; font-size: 13px; font-weight: 500; margin-bottom: 24px; }
    .back:hover { opacity: 0.8; }
    .cert-wrap { max-width: 860px; margin: 0 auto; }
    .cert-actions { display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 20px; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; text-decoration: none; font-family: inherit; }
    .btn-primary { background: #2563EB; color: #fff; }
    .btn-secondary { background: #fff; color: #1a1a2e; border: 1px solid #e8e6e1; }
    
    /* CERTIFICATE */
    .certificate { background: #fff; border: 1px solid #e8e6e1; border-radius: 16px; padding: 60px; position: relative; overflow: hidden; box-shadow: 0 8px 40px rgba(0,0,0,0.08); }
    .cert-border { position: absolute; inset: 12px; border: 2px solid #2563EB; border-radius: 10px; opacity: 0.15; pointer-events: none; }
    .cert-corner { position: absolute; width: 40px; height: 40px; }
    .cert-corner-tl { top: 20px; left: 20px; border-top: 3px solid #2563EB; border-left: 3px solid #2563EB; }
    .cert-corner-tr { top: 20px; right: 20px; border-top: 3px solid #2563EB; border-right: 3px solid #2563EB; }
    .cert-corner-bl { bottom: 20px; left: 20px; border-bottom: 3px solid #2563EB; border-left: 3px solid #2563EB; }
    .cert-corner-br { bottom: 20px; right: 20px; border-bottom: 3px solid #2563EB; border-right: 3px solid #2563EB; }
    
    .cert-logo { text-align: center; margin-bottom: 24px; }
    .cert-logo img { height: 32px; }
    .cert-logo-text { font-size: 13px; font-weight: 600; color: #2563EB; margin-top: 6px; }
    .cert-divider { width: 60px; height: 2px; background: linear-gradient(90deg, #2563EB, #0891b2); margin: 0 auto 24px; border-radius: 2px; }
    .cert-title { font-family: 'DM Serif Display', serif; font-size: 13px; font-weight: 400; letter-spacing: 0.15em; text-transform: uppercase; color: #9090a8; text-align: center; margin-bottom: 8px; }
    .cert-heading { font-family: 'DM Serif Display', serif; font-size: 42px; color: #1a1a2e; text-align: center; margin-bottom: 24px; line-height: 1.1; }
    .cert-text { font-size: 15px; color: #4a4a6a; text-align: center; margin-bottom: 8px; }
    .cert-name { font-family: 'DM Serif Display', serif; font-size: 38px; color: #2563EB; text-align: center; margin: 16px 0; font-style: italic; }
    .cert-course { font-family: 'DM Serif Display', serif; font-size: 22px; color: #1a1a2e; text-align: center; margin: 16px 0; }
    .cert-meta { display: flex; justify-content: center; gap: 40px; margin-top: 40px; padding-top: 32px; border-top: 1px solid #e8e6e1; }
    .cert-meta-item { text-align: center; }
    .cert-meta-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #9090a8; margin-bottom: 4px; }
    .cert-meta-value { font-size: 14px; font-weight: 600; color: #1a1a2e; }
    .cert-seal { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #2563EB, #0891b2); display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; color: #fff; font-size: 32px; }

    @media print {
      body { background: #fff; padding: 0; }
      .back, .cert-actions { display: none; }
      .certificate { box-shadow: none; border: none; }
    }
  </style>
</head>
<body>
  <div class="cert-wrap">
    <a href="{{ route('academy.package', $package->slug) }}" class="back">← Back to course</a>
    
    <div class="cert-actions">
      <button onclick="window.print()" class="btn btn-secondary">🖨 Print</button>
      <button onclick="window.print()" class="btn btn-primary">⬇ Download PDF</button>
    </div>

    <div class="certificate" id="certificate">
      <div class="cert-border"></div>
      <div class="cert-corner cert-corner-tl"></div>
      <div class="cert-corner cert-corner-tr"></div>
      <div class="cert-corner cert-corner-bl"></div>
      <div class="cert-corner cert-corner-br"></div>

      <div class="cert-logo">
        <img src="/images/peopleflow-logo.png" alt="Peopleflow">
        <div class="cert-logo-text">ACADEMY</div>
      </div>

      <div class="cert-divider"></div>

      <div class="cert-title">Certificate of Completion</div>
      <div class="cert-heading">This is to certify that</div>

      <div class="cert-name">{{ $user->name }}</div>

      <div class="cert-text">has successfully completed the course</div>

      <div class="cert-course">{{ $package->title }}</div>

      <div class="cert-text" style="margin-top:8px">
        {{ $completed }} of {{ $totalLessons }} lessons completed
      </div>

      <div class="cert-meta">
        <div class="cert-meta-item">
          <div class="cert-seal">🎓</div>
          <div class="cert-meta-label">Achievement</div>
          <div class="cert-meta-value">{{ $percent }}% Score</div>
        </div>
        <div class="cert-meta-item">
          <div class="cert-seal">📅</div>
          <div class="cert-meta-label">Completed On</div>
          <div class="cert-meta-value">{{ $completedAt ? $completedAt->format('d M Y') : now()->format('d M Y') }}</div>
        </div>
        <div class="cert-meta-item">
          <div class="cert-seal">✅</div>
          <div class="cert-meta-label">Issued By</div>
          <div class="cert-meta-value">Peopleflow Academy</div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
