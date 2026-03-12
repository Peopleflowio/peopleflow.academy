<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Peopleflow Academy</title>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Geist:wght@300;400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    :root{--bg:#f5f4f0;--bg2:#eeece7;--surface:#ffffff;--border:#e4e2db;--border-dark:#d0cdc4;--ink:#1a1916;--ink2:#4a4740;--ink3:#8a8780;--accent:#2563eb;--accent-light:#eff4ff;--accent-border:#bfcffe;--green:#16a34a;--green-light:#f0fdf4;--green-border:#bbf7d0;--amber:#d97706;--amber-light:#fffbeb;--red:#dc2626;--red-light:#fef2f2;--radius:10px;--radius-sm:6px;--shadow:0 1px 3px rgba(0,0,0,0.08),0 1px 2px rgba(0,0,0,0.04)}
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Geist',sans-serif;background:var(--bg);color:var(--ink);min-height:100vh}
    ::-webkit-scrollbar{width:5px;height:5px}::-webkit-scrollbar-thumb{background:var(--border-dark);border-radius:3px}
    .shell{display:flex;height:100vh;overflow:hidden}
    .sidebar{width:232px;min-width:232px;background:var(--ink);display:flex;flex-direction:column;overflow-y:auto}
    .sb-logo{padding:20px 18px 16px;border-bottom:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;gap:10px}
    .sb-logo-mark{width:32px;height:32px;background:var(--accent);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0}
    .sb-logo-text{display:flex;flex-direction:column;line-height:1.15}
    .sb-logo-text .brand{font-family:'Instrument Serif',serif;font-size:15px;color:#fff}
    .sb-logo-text .sub{font-size:10px;color:rgba(255,255,255,0.35);font-weight:500;letter-spacing:0.06em;text-transform:uppercase}
    .sb-badge{margin-left:auto;background:var(--accent);color:white;font-size:10px;font-weight:700;padding:2px 6px;border-radius:4px}
    .sb-section{padding:16px 10px 4px;font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.25)}
    .sb-item{display:flex;align-items:center;gap:9px;padding:8px 10px;border-radius:var(--radius-sm);margin:1px 8px;cursor:pointer;font-size:13px;color:rgba(255,255,255,0.55);text-decoration:none;transition:all 0.12s;position:relative}
    .sb-item:hover{background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.85)}
    .sb-item.active{background:rgba(255,255,255,0.1);color:#fff;font-weight:500}
    .sb-item.active::before{content:'';position:absolute;left:-8px;top:50%;transform:translateY(-50%);width:3px;height:60%;background:var(--accent);border-radius:0 2px 2px 0}
    .sb-icon{width:16px;height:16px;flex-shrink:0;opacity:0.7}
    .sb-item.active .sb-icon{opacity:1}
    .sb-count{margin-left:auto;font-size:11px;background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.5);padding:1px 6px;border-radius:10px}
    .sb-footer{margin-top:auto;padding:14px 18px;border-top:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;gap:10px}
    .sb-avatar{width:28px;height:28px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;color:white;flex-shrink:0}
    .sb-user-name{font-size:12.5px;color:rgba(255,255,255,0.7);font-weight:500}
    .sb-user-role{font-size:10.5px;color:rgba(255,255,255,0.3)}
    .main{flex:1;overflow-y:auto;display:flex;flex-direction:column;background:var(--bg)}
    .topbar{display:flex;align-items:center;gap:12px;padding:12px 28px;background:var(--surface);border-bottom:1px solid var(--border);position:sticky;top:0;z-index:50;box-shadow:var(--shadow)}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-size:13px;color:var(--ink3)}
    .breadcrumb a{color:var(--ink3);text-decoration:none}.breadcrumb a:hover{color:var(--ink)}
    .breadcrumb .sep{color:var(--border-dark)}.breadcrumb .cur{color:var(--ink);font-weight:500}
    .topbar-right{margin-left:auto;display:flex;align-items:center;gap:8px}
    .search-box{display:flex;align-items:center;gap:7px;background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-sm);padding:6px 11px;width:200px}
    .search-box input{background:none;border:none;outline:none;font-family:inherit;font-size:13px;color:var(--ink);width:100%}
    .search-box input::placeholder{color:var(--ink3)}
    .btn-icon{width:32px;height:32px;padding:0;display:flex;align-items:center;justify-content:center;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);cursor:pointer;color:var(--ink3);transition:all 0.12s}
    .btn-icon:hover{background:var(--bg2);color:var(--ink)}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:var(--radius-sm);font-family:inherit;font-size:13px;font-weight:500;cursor:pointer;border:none;transition:all 0.12s;white-space:nowrap;text-decoration:none}
    .btn-primary{background:var(--accent);color:#fff;box-shadow:0 1px 2px rgba(37,99,235,0.3)}.btn-primary:hover{background:#1d4ed8}
    .btn-secondary{background:var(--surface);color:var(--ink2);border:1px solid var(--border)}.btn-secondary:hover{background:var(--bg2)}
    .btn-danger{background:var(--red-light);color:var(--red);border:1px solid #fecaca}
    .btn-sm{padding:5px 10px;font-size:12px}.btn-xs{padding:3px 8px;font-size:11px}
    .page-wrap{padding:24px 28px;display:flex;flex-direction:column;gap:22px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px}
    .page-title{font-family:'Instrument Serif',serif;font-size:26px;font-weight:400;color:var(--ink);line-height:1.2}
    .page-sub{font-size:13px;color:var(--ink3);margin-top:4px}
    .page-actions{display:flex;align-items:center;gap:8px;flex-shrink:0}
    .stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:18px 20px;box-shadow:var(--shadow)}
    .stat-label{font-size:11.5px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);margin-bottom:8px}
    .stat-val{font-family:'Instrument Serif',serif;font-size:30px;font-weight:400;color:var(--ink);line-height:1}
    .stat-meta{font-size:12px;color:var(--ink3);margin-top:5px}
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden}
    .table-card-header{display:flex;align-items:center;justify-content:space-between;padding:14px 18px;border-bottom:1px solid var(--border)}
    .table-card-title{font-size:14px;font-weight:600;color:var(--ink)}
    .tbl{width:100%;border-collapse:collapse}
    .tbl th{text-align:left;padding:10px 16px;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink3);background:var(--bg);border-bottom:1px solid var(--border)}
    .tbl td{padding:13px 16px;font-size:13px;color:var(--ink2);border-bottom:1px solid var(--border);vertical-align:middle}
    .tbl tr:last-child td{border-bottom:none}
    .tbl tbody tr:hover td{background:var(--bg)}
    .tbl .name{color:var(--ink);font-weight:500}
    .tbl .slug{font-family:'Geist Mono',monospace;font-size:11px;color:var(--ink3)}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600}
    .badge-green{background:var(--green-light);color:var(--green);border:1px solid var(--green-border)}
    .badge-amber{background:var(--amber-light);color:var(--amber);border:1px solid #fde68a}
    .badge-grey{background:var(--bg2);color:var(--ink3);border:1px solid var(--border)}
    .dot{width:6px;height:6px;border-radius:50%;display:inline-block;flex-shrink:0}
    .dot-green{background:var(--green)}.dot-amber{background:var(--amber)}
    .alert-success{background:var(--green-light);border:1px solid var(--green-border);color:var(--green);padding:10px 14px;border-radius:var(--radius-sm);font-size:13px;display:flex;align-items:center;gap:8px}
    .alert-error{background:var(--red-light);border:1px solid #fecaca;color:var(--red);padding:10px 14px;border-radius:var(--radius-sm);font-size:13px}
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);padding:22px 24px}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
    .form-full{grid-column:1/-1}
    .field{display:flex;flex-direction:column;gap:5px}
    .field-label{font-size:12px;font-weight:600;color:var(--ink2);text-transform:uppercase;letter-spacing:0.06em}
    .field-hint{font-size:11.5px;color:var(--ink3);margin-top:2px}
    .inp,.sel,.txa{background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-sm);padding:8px 11px;font-family:inherit;font-size:13.5px;color:var(--ink);outline:none;transition:border-color 0.15s,box-shadow 0.15s;width:100%}
    .inp:focus,.sel:focus,.txa:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(37,99,235,0.1)}
    .inp::placeholder{color:var(--ink3)}
    .txa{resize:vertical;min-height:80px;line-height:1.55}
    .sel{appearance:none;cursor:pointer;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238a8780' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;padding-right:28px}
    .lesson-row{display:flex;align-items:center;gap:12px;padding:12px 14px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);transition:all 0.15s}
    .lesson-row:hover{border-color:var(--border-dark);box-shadow:var(--shadow)}
    .lesson-num{width:24px;height:24px;border-radius:50%;background:var(--bg2);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:11px;font-family:'Geist Mono',monospace;color:var(--ink3);flex-shrink:0}
    .lesson-info{flex:1;min-width:0}
    .lesson-name{font-size:13.5px;font-weight:500;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .lesson-meta{display:flex;align-items:center;gap:8px;margin-top:3px;font-size:12px;color:var(--ink3)}
    .no-video{width:64px;height:40px;border-radius:5px;background:var(--bg2);border:1.5px dashed var(--border-dark);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:18px;color:var(--ink3)}
    .has-video{width:64px;height:40px;border-radius:5px;background:#0f172a;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:18px}
    .module-block{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden;margin-bottom:12px}
    .module-header{display:flex;align-items:center;gap:12px;padding:14px 16px;border-bottom:1px solid var(--border);background:var(--bg)}
    .module-icon{width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;background:var(--accent-light)}
    .module-title{font-size:14px;font-weight:600;color:var(--ink)}
    .module-sub{font-size:12px;color:var(--ink3);margin-top:2px}
    .module-body{padding:10px 12px 12px;display:flex;flex-direction:column;gap:6px}
    </style>
</head>
<body>
<div class="shell">
  <aside class="sidebar">
    <div class="sb-logo">
      <div class="sb-logo-mark">🎓</div>
      <div class="sb-logo-text">
        <span class="brand">Peopleflow Academy</span>
        <span class="sub">Admin CMS</span>
      </div>
      <span class="sb-badge">ADMIN</span>
    </div>

<div class="sb-section">Overview</div>
<a href="{{ route('admin.dashboard') }}" class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
  <svg class="sb-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
  Dashboard
</a>


    <div class="sb-section">Content</div>
    <a href="{{ route('admin.academy.packages.index') }}" class="sb-item {{ request()->routeIs('admin.academy.packages*') ? 'active' : '' }}">
      <svg class="sb-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
      Packages
    </a>
    <a href="{{ route('admin.academy.lessons.index') }}" class="sb-item {{ request()->routeIs('admin.academy.lessons*') ? 'active' : '' }}">
      <svg class="sb-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polygon points="5 3 19 12 5 21 5 3"/></svg>
      Lessons & Videos
    </a>
    <div class="sb-section">Operations</div>
    <a href="{{ route('academy.catalog') }}" class="sb-item" target="_blank">
      <svg class="sb-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
      View Learner Side
    </a>
    <div class="sb-footer">
      <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}</div>
      <div>
        <div class="sb-user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
        <div class="sb-user-role">Platform Admin</div>
      </div>
    </div>
  </aside>
  <main class="main">
    <div class="topbar">
      <div class="breadcrumb">
        <a href="{{ route('admin.academy.packages.index') }}">Admin</a>
        <span class="sep">›</span>
        <span class="cur">@yield('breadcrumb', 'Dashboard')</span>
      </div>
      <div class="topbar-right">
        <div class="search-box">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#8a8780" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          <input type="text" placeholder="Search content...">
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="btn-icon" title="Logout">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          </button>
        </form>
      </div>
    </div>
    <div class="page-wrap">
      @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
      @endif
      @if($errors->any())
        <div class="alert-error">
          @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
        </div>
      @endif
      @yield('content')
    </div>
  </main>
</div>
</body>
</html>
