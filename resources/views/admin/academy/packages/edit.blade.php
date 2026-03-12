@extends('layouts.admin')
@section('title', 'Edit: ' . $package->title)
@section('breadcrumb', 'Edit Package')
@section('content')
<div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start">

  {{-- LEFT: PACKAGE FORM + MODULES --}}
  <div style="display:flex;flex-direction:column;gap:16px">
    <div class="page-header">
      <div>
        <div class="page-title">{{ $package->emoji_icon }} {{ $package->title }}</div>
        <div class="page-sub">Edit package details and manage modules</div>
      </div>
      <a href="{{ route('admin.academy.packages.index') }}" class="btn btn-secondary btn-sm">← All Packages</a>
    </div>

    {{-- PACKAGE DETAILS --}}
    <form action="{{ route('admin.academy.packages.update', $package) }}" method="POST" class="form-card" style="display:flex;flex-direction:column;gap:14px">
      @csrf @method('PATCH')
      <div style="font-size:13px;font-weight:600;color:var(--ink3);text-transform:uppercase;letter-spacing:0.07em;margin-bottom:4px">Package Details</div>
      <div class="form-grid">
        <div class="field form-full">
          <label class="field-label">Title</label>
          <input type="text" name="title" value="{{ old('title', $package->title) }}" class="inp">
        </div>
        <div class="field form-full">
          <label class="field-label">Description</label>
          <textarea name="description" rows="2" class="txa">{{ old('description', $package->description) }}</textarea>
        </div>
        <div class="field">
          <label class="field-label">Emoji Icon</label>
          <input type="text" name="emoji_icon" value="{{ old('emoji_icon', $package->emoji_icon) }}" class="inp">
        </div>
        <div class="field">
          <label class="field-label">Price (cents)</label>
          <div style="display:flex;align-items:center;background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-sm);overflow:hidden">
            <span style="padding:0 10px;font-size:13px;font-weight:600;color:var(--ink3);background:var(--bg2);border-right:1px solid var(--border);height:38px;display:flex;align-items:center">$</span>
            <input type="number" name="price_cents" value="{{ old('price_cents', $package->price_cents) }}" style="border:none;background:transparent;padding:8px 11px;font-family:inherit;font-size:14px;font-weight:600;color:var(--ink);outline:none;width:100%">
          </div>
          <div class="field-hint">In cents — e.g. 29900 = $299.00</div>
        </div>
      </div>
      <div style="display:flex;justify-content:space-between;align-items:center;padding-top:8px;border-top:1px solid var(--border)">
        <div style="display:flex;align-items:center;gap:10px">
          <input type="hidden" name="is_published" value="0">
          <input type="checkbox" name="is_published" value="1" id="pkg_pub" {{ $package->is_published ? 'checked' : '' }} style="width:16px;height:16px;cursor:pointer;accent-color:var(--accent)">
          <label for="pkg_pub" style="font-size:13.5px;color:var(--ink2);cursor:pointer">Published</label>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </div>
    </form>

    {{-- MODULES SECTION --}}
    <div class="form-card">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
        <div>
          <div style="font-size:14px;font-weight:600;color:var(--ink)">Modules</div>
          <div style="font-size:12px;color:var(--ink3);margin-top:2px">Organise lessons into modules</div>
        </div>
        <button type="button" onclick="document.getElementById('add-module-form').style.display='block';this.style.display='none'" class="btn btn-secondary btn-sm">+ Add Module</button>
      </div>

      {{-- ADD MODULE FORM --}}
      <div id="add-module-form" style="display:none;background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px;margin-bottom:14px">
        <form action="{{ route('admin.academy.modules.store', $package) }}" method="POST">
          @csrf
          <div style="font-size:12px;font-weight:600;color:var(--ink3);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:10px">New Module</div>
          <div style="display:grid;grid-template-columns:60px 1fr;gap:10px;margin-bottom:10px">
            <div class="field">
              <label class="field-label">Emoji</label>
              <input type="text" name="emoji_icon" value="📋" class="inp" style="text-align:center;font-size:18px">
            </div>
            <div class="field">
              <label class="field-label">Module Title</label>
              <input type="text" name="title" placeholder="e.g. Module 1 — Staffing Actions" class="inp">
            </div>
          </div>
          <div class="field" style="margin-bottom:10px">
            <label class="field-label">Description <span style="font-weight:400;color:var(--ink3)">(optional)</span></label>
            <input type="text" name="description" placeholder="Brief description of this module" class="inp">
          </div>
          <div style="display:flex;gap:8px;justify-content:flex-end">
            <button type="button" onclick="document.getElementById('add-module-form').style.display='none';document.querySelector('[onclick*=add-module]').style.display='inline-flex'" class="btn btn-secondary btn-sm">Cancel</button>
            <button type="submit" class="btn btn-primary btn-sm">Create Module</button>
          </div>
        </form>
      </div>

      {{-- EXISTING MODULES --}}
      @forelse($package->modules as $module)
        <div class="module-block">
          <div class="module-header" style="justify-content:space-between">
            <div style="display:flex;align-items:center;gap:10px">
              <div class="module-icon">{{ $module->emoji_icon }}</div>
              <div>
                <div class="module-title">{{ $module->title }}</div>
                <div class="module-sub">{{ $module->lessons->count() }} lessons</div>
              </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px">
              <a href="{{ route('admin.academy.lessons.create', ['module_id' => $module->id]) }}" class="btn btn-primary btn-xs">+ Add Lesson</a>
              <form method="POST" action="{{ route('admin.academy.modules.destroy', [$package, $module]) }}" onsubmit="return confirm('Delete this module and all its lessons?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-xs">Delete</button>
              </form>
            </div>
          </div>
          <div class="module-body">
            @forelse($module->lessons as $i => $lesson)
              <div class="lesson-row">
                <div class="lesson-num">{{ $i + 1 }}</div>
                <div class="lesson-info">
                  <div class="lesson-name">{{ $lesson->title }}</div>
                  <div class="lesson-meta">
                    <span>{{ ucfirst($lesson->process_type) }}</span>
                    <span style="color:var(--border-dark)">·</span>
                    <span style="font-family:'Geist Mono',monospace">{{ $lesson->duration_formatted }}</span>
                  </div>
                </div>
                @if($lesson->is_published)
                  <span class="badge badge-green"><span class="dot dot-green"></span> Published</span>
                @else
                  <span class="badge badge-amber"><span class="dot dot-amber"></span> Draft</span>
                @endif
                <a href="{{ route('admin.academy.lessons.edit', $lesson) }}" class="btn btn-secondary btn-xs">Edit</a>
              </div>
            @empty
              <div style="padding:14px;text-align:center;color:var(--ink3);font-size:13px">
                No lessons yet —
                <a href="{{ route('admin.academy.lessons.create', ['module_id' => $module->id]) }}" style="color:var(--accent)">add the first one</a>
              </div>
            @endforelse
          </div>
        </div>
      @empty
        <div style="text-align:center;padding:28px;color:var(--ink3);font-size:13px">
          No modules yet — add your first module above
        </div>
      @endforelse
    </div>
  </div>

  {{-- RIGHT: STATS --}}
  <div style="position:sticky;top:80px;display:flex;flex-direction:column;gap:14px">
    <div class="form-card">
      <div style="font-size:13px;font-weight:600;color:var(--ink);margin-bottom:14px">Package Stats</div>
      <div style="display:flex;flex-direction:column;gap:10px">
        <div style="display:flex;justify-content:space-between;font-size:13px">
          <span style="color:var(--ink3)">Modules</span>
          <span style="font-weight:600;color:var(--ink)">{{ $package->modules->count() }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:13px">
          <span style="color:var(--ink3)">Total Lessons</span>
          <span style="font-weight:600;color:var(--ink)">{{ $package->modules->sum(fn($m) => $m->lessons->count()) }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:13px">
          <span style="color:var(--ink3)">Published</span>
          <span style="font-weight:600;color:var(--green)">{{ $package->modules->sum(fn($m) => $m->lessons->where('is_published',true)->count()) }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:13px">
          <span style="color:var(--ink3)">Draft</span>
          <span style="font-weight:600;color:var(--amber)">{{ $package->modules->sum(fn($m) => $m->lessons->where('is_published',false)->count()) }}</span>
        </div>
        <div style="border-top:1px solid var(--border);padding-top:10px;display:flex;justify-content:space-between;font-size:13px">
          <span style="color:var(--ink3)">Price</span>
          <span style="font-weight:600;color:var(--ink);font-family:'Geist Mono',monospace">{{ $package->price_formatted }}</span>
        </div>
      </div>
    </div>

    <div class="form-card">
      <div style="font-size:13px;font-weight:600;color:var(--ink);margin-bottom:10px">Status</div>
      @if($package->is_published)
        <span class="badge badge-green" style="font-size:12px"><span class="dot dot-green"></span> Published — visible in catalog</span>
      @else
        <span class="badge badge-amber" style="font-size:12px"><span class="dot dot-amber"></span> Draft — hidden from learners</span>
      @endif
    </div>

    <form method="POST" action="{{ route('admin.academy.packages.destroy', $package) }}" onsubmit="return confirm('Permanently delete this package?')">
      @csrf @method('DELETE')
      <button class="btn btn-danger btn-sm" style="width:100%;justify-content:center">Delete Package</button>
    </form>
  </div>
</div>
@endsection
