<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $package->title }} — Peopleflow Academy</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Plus Jakarta Sans',sans-serif;background:#F5F4F0;color:#1a1a2e}
    a{text-decoration:none;color:inherit}
    
    /* NAV */
    nav{position:fixed;top:0;left:0;right:0;z-index:100;display:flex;align-items:center;justify-content:space-between;padding:16px 56px;border-bottom:1px solid rgba(26,26,46,0.1);background:rgba(245,244,240,0.95);backdrop-filter:blur(16px)}
    .nav-logo{display:flex;align-items:center;gap:8px}
    .nav-logo img{height:24px}
    .nav-logo span{font-size:14px;font-weight:700;color:#2563EB}
    .nav-links{display:flex;align-items:center;gap:20px}
    .nav-links a{font-size:13px;color:#4a4a6a}
    .nav-cta{background:#2563EB;color:#fff!important;padding:8px 18px;border-radius:7px;font-weight:600!important;font-size:13px}

    /* LAYOUT */
    .page{max-width:1100px;margin:0 auto;padding:100px 24px 60px;display:grid;grid-template-columns:1fr 340px;gap:40px;align-items:start}
    
    /* LEFT CONTENT */
    .breadcrumb{font-size:12px;color:#9090a8;margin-bottom:16px}
    .breadcrumb a{color:#2563EB}
    .course-tag{display:inline-flex;align-items:center;gap:6px;background:#EEF2FF;color:#2563EB;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;margin-bottom:16px}
    .course-title{font-family:'DM Serif Display',serif;font-size:40px;color:#1a1a2e;line-height:1.1;margin-bottom:16px}
    .course-desc{font-size:15px;color:#4a4a6a;line-height:1.8;margin-bottom:24px}
    .course-meta{display:flex;gap:20px;flex-wrap:wrap;margin-bottom:32px}
    .meta-item{display:flex;align-items:center;gap:6px;font-size:13px;color:#4a4a6a}

    /* WHAT YOU'LL LEARN */
    .learn-box{background:#fff;border:1px solid #e8e6e1;border-radius:12px;padding:24px;margin-bottom:24px}
    .learn-box h2{font-family:'DM Serif Display',serif;font-size:20px;color:#1a1a2e;margin-bottom:16px}
    .learn-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
    .learn-item{display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#4a4a6a}
    .learn-item::before{content:'✓';color:#2563EB;font-weight:700;flex-shrink:0;margin-top:1px}

    /* CURRICULUM */
    .curriculum h2{font-family:'DM Serif Display',serif;font-size:24px;color:#1a1a2e;margin-bottom:16px}
    .module-card{background:#fff;border:1px solid #e8e6e1;border-radius:12px;overflow:hidden;margin-bottom:12px}
    .module-header{padding:16px 20px;background:#F5F4F0;display:flex;align-items:center;justify-content:space-between;cursor:pointer}
    .module-title{font-size:14px;font-weight:600;color:#1a1a2e}
    .module-meta{font-size:12px;color:#9090a8}
    .module-badge{background:#EEF2FF;color:#2563EB;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700}
    .lesson-row{display:flex;align-items:center;gap:12px;padding:12px 20px;border-top:1px solid #e8e6e1}
    .lesson-icon{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;flex-shrink:0}
    .lesson-free{background:#EEF2FF;color:#2563EB}
    .lesson-locked{background:#F5F4F0;color:#9090a8}
    .lesson-title{flex:1;font-size:13px;color:#1a1a2e}
    .lesson-title.locked{color:#9090a8}
    .lesson-duration{font-size:12px;color:#9090a8;font-family:monospace}
    .free-tag{background:#dcfce7;color:#16a34a;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700}
    .lock-icon{color:#9090a8;font-size:14px}

    /* STICKY SIDEBAR */
    .sidebar-sticky{position:sticky;top:100px}
    .enroll-card{background:#fff;border:1px solid #e8e6e1;border-radius:16px;padding:28px;box-shadow:0 8px 32px rgba(0,0,0,0.08)}
    .enroll-price{font-family:'DM Serif Display',serif;font-size:42px;color:#1a1a2e;margin-bottom:4px}
    .enroll-price span{font-size:16px;color:#9090a8;font-family:'Plus Jakarta Sans',sans-serif}
    .enroll-btn{display:block;width:100%;padding:14px;background:#2563EB;color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:700;cursor:pointer;text-align:center;margin:16px 0;font-family:inherit;transition:background 0.2s}
    .enroll-btn:hover{background:#1d4ed8}
    .enroll-btn.enrolled{background:#16a34a}
    .enroll-includes{list-style:none;margin-top:16px}
    .enroll-includes li{display:flex;align-items:center;gap:8px;font-size:13px;color:#4a4a6a;padding:6px 0;border-bottom:1px solid #f0ede8}
    .enroll-includes li:last-child{border:none}
    .enroll-includes li::before{content:'✓';color:#2563EB;font-weight:700}

    @media(max-width:768px){
      nav{padding:16px 20px}
      .page{grid-template-columns:1fr;padding:80px 16px 40px}
      .sidebar-sticky{position:static}
      .learn-grid{grid-template-columns:1fr}
    }
  </style>
</head>
<body>

{{-- NAV --}}
<nav>
  <a href="{{ route('home') }}" class="nav-logo">
    <img src="/images/peopleflow-logo.png" alt="Peopleflow">
    <span>Academy</span>
  </a>
  <div class="nav-links">
    <a href="{{ route('home') }}#courses">Courses</a>
    <a href="{{ route('home') }}#for-who">Who It's For</a>
    @auth
      <a href="{{ route('academy.dashboard') }}" class="nav-cta">My Dashboard</a>
    @else
      <a href="{{ route('login') }}">Sign In</a>
      <a href="{{ route('register') }}" class="nav-cta">Get Started</a>
    @endauth
  </div>
</nav>

<div class="page">
  {{-- LEFT CONTENT --}}
  <div>
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Home</a> › <a href="{{ route('home') }}#courses">Courses</a> › {{ $package->title }}
    </div>

    <div class="course-tag">{{ $package->emoji_icon }} Course</div>
    <h1 class="course-title">{{ $package->title }}</h1>
    <p class="course-desc">{{ $package->description }}</p>

    <div class="course-meta">
      <div class="meta-item">📚 {{ $package->modules->sum(fn($m) => $m->lessons->count()) }} lessons</div>
      <div class="meta-item">📁 {{ $package->modules->count() }} modules</div>
      <div class="meta-item">⏱ Lifetime access</div>
      <div class="meta-item">🏆 Certificate included</div>
      <div class="meta-item">📝 Quiz included</div>
    </div>

    {{-- WHAT YOU'LL LEARN --}}
    <div class="learn-box">
      <h2>What you'll learn</h2>
      <div class="learn-grid">
        @foreach($package->modules->take(8) as $module)
          <div class="learn-item">{{ $module->title }}</div>
        @endforeach
      </div>
    </div>

    {{-- CURRICULUM --}}
    <div class="curriculum">
      <h2>Course Curriculum</h2>
      <p style="font-size:13px;color:#9090a8;margin-bottom:16px">
        First module is free to preview — enroll to access all content
      </p>

      @foreach($package->modules as $moduleIndex => $module)
        <div class="module-card">
          <div class="module-header" onclick="toggleModule({{ $module->id }})">
            <div>
              <div class="module-title">{{ $module->title }}</div>
              <div class="module-meta">{{ $module->lessons->count() }} lessons</div>
            </div>
            <div style="display:flex;align-items:center;gap:8px">
              @if($moduleIndex === 0)
                <span class="module-badge">FREE PREVIEW</span>
              @endif
              <span id="chevron-{{ $module->id }}">▼</span>
            </div>
          </div>
          <div id="module-{{ $module->id }}" style="{{ $moduleIndex === 0 ? '' : 'display:none' }}">
            @foreach($module->lessons as $lesson)
              <div class="lesson-row">
                @if($moduleIndex === 0)
                  <div class="lesson-icon lesson-free">▶</div>
                  <a href="{{ route('academy.lesson', [$package->slug, $lesson->slug]) }}" class="lesson-title">{{ $lesson->title }}</a>
                  <span class="free-tag">FREE</span>
                @else
                  <div class="lesson-icon lesson-locked">🔒</div>
                  <span class="lesson-title locked">{{ $lesson->title }}</span>
                  <span class="lock-icon">🔒</span>
                @endif
                <span class="lesson-duration">{{ $lesson->duration_formatted }}</span>
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    </div>
  </div>

  {{-- STICKY SIDEBAR --}}
  <div class="sidebar-sticky">
    <div class="enroll-card">
      <div class="enroll-price">{{ $package->price_formatted }} <span>/ seat</span></div>
      
      @if($enrolled)
        <a href="{{ route('academy.package', $package->slug) }}" class="enroll-btn enrolled">▶ Continue Learning</a>
      @elseif(auth()->check())
        <a href="{{ route('academy.checkout', $package->slug) }}" class="enroll-btn">Enroll Now →</a>
      @else
        <a href="{{ route('register') }}?intended={{ urlencode(route('academy.checkout', $package->slug)) }}" class="enroll-btn">Enroll Now →</a>
      @endif

      <ul class="enroll-includes">
        <li>{{ $package->modules->sum(fn($m) => $m->lessons->count()) }} video lessons</li>
        <li>Lifetime access</li>
        <li>Certificate of completion</li>
        <li>Quiz & assessment</li>
        <li>Mobile & desktop access</li>
      </ul>
    </div>
  </div>
</div>

<script>
function toggleModule(id) {
    const content = document.getElementById('module-' + id);
    const chevron = document.getElementById('chevron-' + id);
    if (content.style.display === 'none') {
        content.style.display = 'block';
        chevron.textContent = '▲';
    } else {
        content.style.display = 'none';
        chevron.textContent = '▼';
    }
}
</script>
</body>
</html>
