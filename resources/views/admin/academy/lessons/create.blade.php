@extends('layouts.admin')
@section('title', 'New Lesson')
@section('breadcrumb', 'New Lesson')
@section('content')
<div style="max-width:760px">
  <div class="page-header" style="margin-bottom:20px">
    <div>
      <div class="page-title">Create New Lesson</div>
      <div class="page-sub">Add a new lesson to a module</div>
    </div>
    <a href="{{ route('admin.academy.lessons.index') }}" class="btn btn-secondary btn-sm">← All Lessons</a>
  </div>

  <form action="{{ route('admin.academy.lessons.store') }}" method="POST" id="lesson-form">
    @csrf

    {{-- BASIC INFO --}}
    <div class="form-card" style="margin-bottom:16px">
      <div style="font-size:13px;font-weight:600;color:var(--ink3);text-transform:uppercase;letter-spacing:0.07em;margin-bottom:16px">Lesson Details</div>
      <div class="form-grid">
        <div class="field form-full">
          <label class="field-label">Title</label>
          <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Hire Employee — New Worker" class="inp">
        </div>
        <div class="field form-full">
          <label class="field-label">Description</label>
          <textarea name="description" rows="2" placeholder="Brief description of what this lesson covers" class="txa">{{ old('description') }}</textarea>
        </div>
        <div class="field">
          <label class="field-label">Module</label>
          <select name="module_id" class="sel">
            @foreach($packages as $pkg)
              <optgroup label="{{ $pkg->title }}">
                @foreach($pkg->modules as $mod)
                  <option value="{{ $mod->id }}" {{ (old('module_id') == $mod->id || ($module && $module->id == $mod->id)) ? 'selected' : '' }}>{{ $mod->title }}</option>
                @endforeach
              </optgroup>
            @endforeach
          </select>
        </div>
        <div class="field">
          <label class="field-label">Process Type</label>
          <select name="process_type" class="sel">
            @foreach(['staffing','org','compensation','reporting','other'] as $type)
              <option value="{{ $type }}" {{ old('process_type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
            @endforeach
          </select>
        </div>
        <div class="field">
          <label class="field-label">Difficulty</label>
          <select name="difficulty" class="sel">
            @foreach(['beginner','intermediate','advanced'] as $d)
              <option value="{{ $d }}" {{ old('difficulty') == $d ? 'selected' : '' }}>{{ ucfirst($d) }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>

    {{-- SUPPORTING MATERIALS --}}
    <div class="form-card" style="margin-bottom:16px">
      <div style="font-size:13px;font-weight:600;color:var(--ink);margin-bottom:4px">Supporting Materials <span style="color:var(--ink3);font-weight:400;font-size:12px">(optional)</span></div>
      <div style="font-size:12px;color:var(--ink3);margin-bottom:14px">Attach PDFs, spreadsheets or script links for learners to download</div>

      <div id="materials-list" style="display:flex;flex-direction:column;gap:8px;margin-bottom:12px"></div>

      <div style="display:flex;gap:8px;flex-wrap:wrap">
        <button type="button" onclick="addMaterial('pdf')" class="btn btn-secondary btn-sm">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Add PDF
        </button>
        <button type="button" onclick="addMaterial('xlsx')" class="btn btn-secondary btn-sm">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Add XLSX
        </button>
        <button type="button" onclick="addMaterial('script_link')" class="btn btn-secondary btn-sm">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Add Script Link
        </button>
      </div>
    </div>

    {{-- PROCESS STEPS --}}
    <div class="form-card" style="margin-bottom:16px">
      <div style="font-size:13px;font-weight:600;color:var(--ink);margin-bottom:4px">Process Steps <span style="color:var(--ink3);font-weight:400;font-size:12px">(shown alongside the video)</span></div>
      <div style="font-size:12px;color:var(--ink3);margin-bottom:14px">Add step-by-step navigation instructions learners follow in Workday</div>

      <div id="steps-list" style="display:flex;flex-direction:column;gap:8px;margin-bottom:12px"></div>

      <button type="button" onclick="addStep()" class="btn btn-secondary btn-sm">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Step
      </button>
    </div>

    {{-- PUBLISH --}}
    <div class="form-card" style="margin-bottom:20px">
      <div style="display:flex;align-items:center;justify-content:space-between">
        <div>
          <div style="font-size:14px;font-weight:500;color:var(--ink)">Publish immediately</div>
          <div style="font-size:12px;color:var(--ink3);margin-top:2px">Make visible to enrolled learners right away</div>
        </div>
        <label style="position:relative;width:44px;height:24px;cursor:pointer">
          <input type="checkbox" name="is_published" value="1" id="pub" style="opacity:0;width:0;height:0;position:absolute" {{ old('is_published') ? 'checked' : '' }}>
          <span id="toggle-track" onclick="togglePublish()" style="position:absolute;inset:0;background:var(--border-dark);border-radius:12px;transition:0.2s;cursor:pointer">
            <span id="toggle-thumb" style="position:absolute;width:18px;height:18px;left:3px;top:3px;background:white;border-radius:50%;transition:0.2s;box-shadow:0 1px 3px rgba(0,0,0,0.2)"></span>
          </span>
        </label>
      </div>
    </div>

    {{-- FOOTER --}}
    <div style="display:flex;align-items:center;justify-content:flex-end;gap:10px">
      <a href="{{ route('admin.academy.lessons.index') }}" class="btn btn-secondary">Cancel</a>
      <button type="submit" name="save_draft" value="1" class="btn btn-secondary">Save as Draft</button>
      <button type="submit" class="btn btn-primary">Create Lesson</button>
    </div>
  </form>
</div>

<script>
let stepCount = 0;
let materialCount = 0;

function addStep() {
  const i = stepCount++;
  const div = document.createElement('div');
  div.id = 'step-' + i;
  div.style.cssText = 'display:flex;gap:10px;align-items:flex-start;padding:12px 14px;background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-sm)';
  div.innerHTML = `
    <div style="width:22px;height:22px;border-radius:50%;background:var(--accent-light);border:1px solid var(--accent-border);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:var(--accent);flex-shrink:0;margin-top:8px">${stepCount}</div>
    <div style="flex:1;display:flex;flex-direction:column;gap:6px">
      <input type="text" name="steps[${i}][title]" placeholder="Step title, e.g. Navigate to Worker Profile" class="inp" style="font-size:13px;padding:7px 10px">
      <input type="text" name="steps[${i}][nav_path]" placeholder="Navigation path, e.g. Worker → Actions → Job Change → Terminate" class="inp" style="font-size:12px;padding:6px 10px;color:var(--ink3)">
    </div>
    <button type="button" onclick="document.getElementById('step-${i}').remove()" style="background:none;border:none;cursor:pointer;color:var(--ink3);padding:6px;border-radius:4px;margin-top:4px;font-size:18px;line-height:1" onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='var(--ink3)'">×</button>
  `;
  document.getElementById('steps-list').appendChild(div);
}

function addMaterial(type) {
  const i = materialCount++;
  const icons = {pdf: '📄', xlsx: '📊', script_link: '🔗'};
  const labels = {pdf: 'PDF Document', xlsx: 'Excel Spreadsheet', script_link: 'Script Link'};
  const placeholders = {pdf: 'Process Checklist', xlsx: 'Data Template', script_link: 'https://...'};
  const div = document.createElement('div');
  div.id = 'material-' + i;
  div.style.cssText = 'display:flex;align-items:center;gap:10px;padding:10px 12px;background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-sm)';
  div.innerHTML = `
    <div style="width:32px;height:32px;border-radius:6px;background:var(--accent-light);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0">${icons[type]}</div>
    <div style="flex:1;display:flex;flex-direction:column;gap:4px">
      <div style="font-size:11px;font-weight:600;color:var(--ink3);text-transform:uppercase;letter-spacing:0.06em">${labels[type]}</div>
      <input type="text" name="materials[${i}][label]" placeholder="${placeholders[type]}" class="inp" style="font-size:13px;padding:5px 8px">
      <input type="hidden" name="materials[${i}][type]" value="${type}">
      ${type === 'script_link' ? `<input type="text" name="materials[${i}][url]" placeholder="https://..." class="inp" style="font-size:12px;padding:5px 8px">` : `<div style="font-size:11px;color:var(--ink3)">File upload available after lesson is created</div>`}
    </div>
    <button type="button" onclick="document.getElementById('material-${i}').remove()" style="background:none;border:none;cursor:pointer;color:var(--ink3);font-size:18px;line-height:1" onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='var(--ink3)'">×</button>
  `;
  document.getElementById('materials-list').appendChild(div);
}

function togglePublish() {
  const cb = document.getElementById('pub');
  cb.checked = !cb.checked;
  const track = document.getElementById('toggle-track');
  const thumb = document.getElementById('toggle-thumb');
  if (cb.checked) {
    track.style.background = 'var(--accent)';
    thumb.style.transform = 'translateX(20px)';
  } else {
    track.style.background = 'var(--border-dark)';
    thumb.style.transform = 'translateX(0)';
  }
}

// Init toggle state
window.addEventListener('load', function() {
  const cb = document.getElementById('pub');
  if (cb.checked) {
    document.getElementById('toggle-track').style.background = 'var(--accent)';
    document.getElementById('toggle-thumb').style.transform = 'translateX(20px)';
  }
  // Add one default step
  addStep();
});
</script>
@endsection
