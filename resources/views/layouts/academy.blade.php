<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Process Academy')</title>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Geist:wght@300;400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    :root{--bg:#F5F4F0;--bg2:#ffffff;--surface:#ffffff;--surface2:#F0EEE9;--border:#e8e6e1;--border2:#dddbd6;--ink:#1a1a2e;--ink2:#4a4a6a;--ink3:#9090a8;--accent:#2563EB;--accent2:#1d4ed8;--accent-light:rgba(37,99,235,0.08);--green:#16a34a;--green-bg:rgba(22,163,74,0.08);--amber:#d97706;--amber-bg:rgba(217,119,6,0.08);--red:#dc2626;--radius:12px;--radius-sm:8px;--shadow:0 1px 3px rgba(0,0,0,0.08)}
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Geist',sans-serif;background:var(--bg);color:var(--ink);min-height:100vh}
    ::-webkit-scrollbar{width:5px}::-webkit-scrollbar-thumb{background:#c8c6c0;border-radius:3px}
    a{text-decoration:none;color:inherit}
    .shell{display:flex;height:100vh;overflow:hidden}

    /* SIDEBAR */
    .sidebar{width:240px;min-width:240px;background:var(--bg2);border-right:1px solid var(--border);display:flex;flex-direction:column;overflow-y:auto}
    .sb-logo{padding:20px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px}
    .sb-logo-mark{width:34px;height:34px;background:var(--accent);border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
    .sb-logo-text .brand{font-family:'Instrument Serif',serif;font-size:15px;color:var(--ink);display:block}
    .sb-logo-text .sub{font-size:10px;color:var(--ink3);text-transform:uppercase;letter-spacing:0.06em;font-weight:500}
    .sb-section{padding:16px 14px 4px;font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;color:var(--ink3)}
    .sb-item{display:flex;align-items:center;gap:9px;padding:8px 10px;border-radius:var(--radius-sm);margin:1px 6px;font-size:13px;color:var(--ink2);transition:all 0.12s;cursor:pointer}
    .sb-item:hover{background:var(--surface2);color:var(--ink)}
    .sb-item.active{background:var(--accent-light);color:var(--accent)}
    .sb-icon{width:16px;height:16px;flex-shrink:0;opacity:0.6}
    .sb-item.active .sb-icon{opacity:1}
    .sb-footer{margin-top:auto;padding:14px 18px;border-top:1px solid var(--border);display:flex;align-items:center;gap:10px}
    .sb-avatar{width:30px;height:30px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;color:white;flex-shrink:0}
    .sb-user-name{font-size:13px;color:var(--ink);font-weight:500}
    .sb-user-role{font-size:11px;color:var(--ink3)}

    /* MAIN */
    .main{flex:1;overflow-y:auto;display:flex;flex-direction:column}

    /* TOPBAR */
    .topbar{display:flex;align-items:center;gap:12px;padding:14px 28px;background:var(--bg2);border-bottom:1px solid var(--border);position:sticky;top:0;z-index:50}
    .topbar-title{font-size:15px;font-weight:600;color:var(--ink)}
    .topbar-right{margin-left:auto;display:flex;align-items:center;gap:10px}
    .search-box{display:flex;align-items:center;gap:7px;background:var(--surface);border:1px solid var(--border2);border-radius:var(--radius-sm);padding:7px 12px;width:220px}
    .search-box input{background:none;border:none;outline:none;font-family:inherit;font-size:13px;color:var(--ink);width:100%}
    .search-box input::placeholder{color:var(--ink3)}

    /* BUTTONS */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:inherit;font-size:13px;font-weight:500;cursor:pointer;border:none;transition:all 0.12s;white-space:nowrap;text-decoration:none}
    .btn-primary{background:var(--accent);color:#fff}.btn-primary:hover{background:var(--accent2)}
    .btn-secondary{background:var(--surface2);color:var(--ink2);border:1px solid var(--border2)}.btn-secondary:hover{background:var(--border)}
    .btn-sm{padding:5px 12px;font-size:12px}

    /* PAGE */
    .page-wrap{padding:28px;display:flex;flex-direction:column;gap:24px}

    /* CARDS */
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius)}
    .card-body{padding:20px}

    /* BADGES */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600}
    .badge-green{background:var(--green-bg);color:var(--green);border:1px solid rgba(34,197,94,0.2)}
    .badge-amber{background:var(--amber-bg);color:var(--amber);border:1px solid rgba(245,158,11,0.2)}
    .badge-blue{background:var(--accent-light);color:var(--accent);border:1px solid rgba(59,130,246,0.2)}
    .dot{width:6px;height:6px;border-radius:50%;display:inline-block;flex-shrink:0}
    .dot-green{background:var(--green)}.dot-amber{background:var(--amber)}.dot-blue{background:var(--accent)}

    /* PROGRESS BAR */
    .progress-track{height:4px;background:var(--border2);border-radius:2px;overflow:hidden}
    .progress-fill{height:100%;border-radius:2px;transition:width 0.3s}
    .progress-fill-blue{background:var(--accent)}
    .progress-fill-green{background:var(--green)}

    /* ALERT */
    .alert-success{background:var(--green-bg);border:1px solid rgba(34,197,94,0.2);color:var(--green);padding:10px 14px;border-radius:var(--radius-sm);font-size:13px}
    </style>
</head>
<body>
<div class="shell">
  <aside class="sidebar">
    <div class="sb-logo">
      <a href="{{ route('home') }}" style="display:flex;align-items:center;gap:8px;text-decoration:none">
        <img src="/images/peopleflow-logo.png" alt="Peopleflow" style="height:24px;width:auto;">
        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:#2563EB;">Academy</span>
      </a>
    </div>

    <div class="sb-section">Learn</div>
    <a href="{{ route('academy.dashboard') }}" class="sb-item {{ request()->routeIs('academy.dashboard') ? 'active' : '' }}">
      <svg class="sb-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
      Dashboard
    </a>
    <a href="{{ route('academy.catalog') }}" class="sb-item {{ request()->routeIs('academy.catalog') ? 'active' : '' }}">
      <svg class="sb-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
      Catalog
    </a>

    <a href="{{ route('academy.referrals') }}" class="sb-item {{ request()->routeIs('academy.referrals') ? 'active' : '' }}">
      <svg class="sb-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      Referrals
    </a>
    @auth
      @if(auth()->user()->isAdmin())
        <div class="sb-section">Admin</div>
        <a href="{{ route('admin.academy.lessons.index') }}" class="sb-item">
          <svg class="sb-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
          Content CMS
        </a>
      @endif
    @endauth

   <div class="sb-footer">
  @auth
    <a href="{{ route('academy.profile') }}" style="display:flex;align-items:center;gap:10px;text-decoration:none;flex:1;min-width:0">
      <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
      <div style="min-width:0">
        <div class="sb-user-name">{{ auth()->user()->name }}</div>
        <div style="font-size:11px;color:var(--ink3)">View Profile</div>
      </div>
    </a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button style="background:none;border:none;color:var(--ink3);font-size:11px;cursor:pointer;font-family:inherit;padding:0;margin-left:8px">Logout</button>
    </form>
  @endauth
</div>
  </aside>

  <main class="main">
    <div class="topbar">
      <div class="topbar-title">@yield('topbar-title', 'Peopleflow Academy')</div>
      <div class="topbar-right">
        <div class="search-box">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--ink3)"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          <input type="text" placeholder="Search processes...">
        </div>
      </div>
    </div>
    <div class="page-wrap">
      @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
      @endif
      @yield('content')
    </div>
  </main>
</div>
</body>
</html>
