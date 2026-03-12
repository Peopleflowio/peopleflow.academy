@extends('layouts.admin')
@section('title', 'Packages')
@section('breadcrumb', 'Packages')
@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Packages</div>
    <div class="page-sub">Top-level products customers purchase</div>
  </div>
  <div class="page-actions">
    <a href="{{ route('admin.academy.packages.create') }}" class="btn btn-primary">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      New Package
    </a>
  </div>
</div>

<div class="stats-row">
  <div class="stat-card">
    <div class="stat-label">Total Packages</div>
    <div class="stat-val">{{ $packages->count() }}</div>
    <div class="stat-meta">{{ $packages->where('is_published', true)->count() }} published</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Total Lessons</div>
    <div class="stat-val">{{ $packages->sum('lessons_count') }}</div>
    <div class="stat-meta">Across all packages</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Published</div>
    <div class="stat-val">{{ $packages->where('is_published', true)->count() }}</div>
    <div class="stat-meta">Available to learners</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Draft</div>
    <div class="stat-val">{{ $packages->where('is_published', false)->count() }}</div>
    <div class="stat-meta">Not yet live</div>
  </div>
</div>

<div class="table-card">
  <div class="table-card-header">
    <div class="table-card-title">All Packages</div>
    <a href="{{ route('admin.academy.packages.create') }}" class="btn btn-primary btn-sm">+ New Package</a>
  </div>
  <table class="tbl">
    <thead>
      <tr>
        <th>Package</th>
        <th>Modules</th>
        <th>Lessons</th>
        <th>Price / Seat</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($packages as $package)
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:10px">
              <div style="width:36px;height:36px;border-radius:8px;background:var(--accent-light);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">{{ $package->emoji_icon }}</div>
              <div>
                <div class="name">{{ $package->title }}</div>
                <div class="slug">{{ $package->slug }}</div>
              </div>
            </div>
          </td>
          <td>{{ $package->modules_count ?? $package->modules->count() }}</td>
          <td>{{ $package->lessons_count }}</td>
          <td style="font-family:'Geist Mono',monospace;font-weight:600">{{ $package->price_formatted }}</td>
          <td>
            @if($package->is_published)
              <span class="badge badge-green"><span class="dot dot-green"></span> Published</span>
            @else
              <span class="badge badge-amber"><span class="dot dot-amber"></span> Draft</span>
            @endif
          </td>
          <td>
            <div style="display:flex;align-items:center;gap:8px">
              <a href="{{ route('admin.academy.packages.edit', $package) }}" class="btn btn-secondary btn-xs">Edit Content</a>
              <form method="POST" action="{{ route('admin.academy.packages.destroy', $package) }}" onsubmit="return confirm('Delete this package?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-xs">Delete</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--ink3)">No packages yet — create your first one</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
