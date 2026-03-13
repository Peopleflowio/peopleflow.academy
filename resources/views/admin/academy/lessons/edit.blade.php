@extends('layouts.admin')
@section('title', 'Edit: ' . $lesson->title)
@section('breadcrumb', 'Edit Lesson')
@section('content')
<div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start">

  {{-- LEFT --}}
  <div style="display:flex;flex-direction:column;gap:16px">
    <div class="page-header">
      <div>
        <div class="page-title">Edit Lesson</div>
        <div class="page-sub">{{ $lesson->module->package->title }} › {{ $lesson->module->title }}</div>
      </div>
      <a href="{{ route('admin.academy.lessons.index') }}" class="btn btn-secondary btn-sm">← All Lessons</a>
    </div>

    <form action="{{ route('admin.academy.lessons.update', $lesson) }}" method="POST" id="lesson-form">
      @csrf @method('PATCH')

      {{-- BASIC INFO --}}
      <div class="form-card" style="margin-bottom:16px">
        <div style="font-size:13px;font-weight:600;color:var(--ink3);text-transform:uppercase;letter-spacing:0.07em;margin-bottom:16px">Lesson Details</div>
        <div class="form-grid">
          <div class="field form-full">
            <label class="field-label">Title</label>
            <input type="text" name="title" value="{{ old('title', $lesson->title) }}" class="inp">
          </div>
          <div class="field form-full">
            <label class="field-label">Description</label>
            <textarea name="description" rows="2" class="txa">{{ old('description', $lesson->description) }}</textarea>
          </div>
          <div class="field">
            <label class="field-label">Module</label>
            <select name="module_id" class="sel">
              @foreach($packages as $pkg)
                <optgroup label="{{ $pkg->title }}">
                  @foreach($pkg->modules as $mod)
                    <option value="{{ $mod->id }}" {{ $lesson->module_id == $mod->id ? 'selected' : '' }}>{{ $mod->title }}</option>
                  @endforeach
                </optgroup>
              @endforeach
            </select>
          </div>
          <div class="field">
            <label class="field-label">Process Type</label>
            <select name="process_type" class="sel">
              @foreach(['staffing','org','compensation','reporting','other'] as $type)
                <option value="{{ $type }}" {{ $lesson->process_type == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
              @endforeach
            </select>
          </div>
          <div class="field">
            <label class="field-label">Difficulty</label>
            <select name="difficulty" class="sel">
              @foreach(['beginner','intermediate','advanced'] as $d)
                <option value="{{ $d }}" {{ $lesson->difficulty == $d ? 'selected' : '' }}>{{ ucfirst($d) }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      {{-- PROCESS STEPS --}}
      <div class="form-card" style="margin-bottom:16px">
        <div style="font-size:13px;font-weight:600;color:var(--ink);margin-bottom:4px">Process Steps <span style="color:var(--ink3);font-weight:400;font-size:12px">(shown alongside the video)</span></div>
        <div style="font-size:12px;color:var(--ink3);margin-bottom:14px">Step-by-step navigation instructions learners follow in Workday</div>
        <div id="steps-list" style="display:flex;flex-direction:column;gap:8px;margin-bottom:12px">
          @foreach($lesson->steps as $i => $step)
            <div id="step-{{ $i }}" style="display:flex;gap:10px;align-items:flex-start;padding:12px 14px;background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-sm)">
              <div style="width:22px;height:22px;border-radius:50%;background:var(--accent-light);border:1px solid var(--accent-border);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:var(--accent);flex-shrink:0;margin-top:8px">{{ $loop->iteration }}</div>
              <div style="flex:1;display:flex;flex-direction:column;gap:6px">
                <input type="text" name="steps[{{ $i }}][title]" value="{{ $step->title }}" placeholder="Step title" class="inp" style="font-size:13px;padding:7px 10px">
                <input type="text" name="steps[{{ $i }}][nav_path]" value="{{ $step->nav_path }}" placeholder="Navigation path, e.g. Worker → Actions → Job Change" class="inp" style="font-size:12px;padding:6px 10px;color:var(--ink3)">
              </div>
              <button type="button" onclick="document.getElementById('step-{{ $i }}').remove()" style="background:none;border:none;cursor:pointer;color:var(--ink3);padding:6px;font-size:18px;line-height:1;margin-top:4px" onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='var(--ink3)'">×</button>
            </div>
          @endforeach
        </div>
        <button type="button" onclick="addStep()" class="btn btn-secondary btn-sm">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Add Step
        </button>
      </div>

      {{-- PUBLISH TOGGLE --}}
      <div class="form-card" style="margin-bottom:16px">
        <div style="display:flex;align-items:center;justify-content:space-between">
          <div>
            <div style="font-size:14px;font-weight:500;color:var(--ink)">Published</div>
            <div style="font-size:12px;color:var(--ink3);margin-top:2px">Make visible to enrolled learners</div>
          </div>
          <div style="display:flex;align-items:center;gap:10px">
            <span id="pub-label" style="font-size:12px;color:var(--ink3)">{{ $lesson->is_published ? 'Published' : 'Draft' }}</span>
            <div id="toggle-track" onclick="togglePublish()" style="width:44px;height:24px;border-radius:12px;background:{{ $lesson->is_published ? 'var(--accent)' : 'var(--border-dark)' }};position:relative;cursor:pointer;transition:background 0.2s">
              <div id="toggle-thumb" style="position:absolute;width:18px;height:18px;top:3px;left:3px;background:white;border-radius:50%;box-shadow:0 1px 3px rgba(0,0,0,0.2);transition:transform 0.2s;transform:{{ $lesson->is_published ? 'translateX(20px)' : 'translateX(0)' }}"></div>
            </div>
            <input type="hidden" name="is_published" id="pub-input" value="{{ $lesson->is_published ? '1' : '0' }}">
          </div>
        </div>
      </div>

      {{-- FOOTER --}}
      <div style="display:flex;justify-content:space-between;align-items:center">
        <button type="button" onclick="document.getElementById('del').submit()" style="background:none;border:none;font-size:13px;color:var(--red);cursor:pointer;font-family:inherit">Delete Lesson</button>
        <div style="display:flex;gap:10px">
          <a href="{{ route('admin.academy.lessons.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </form>
    <form id="del" action="{{ route('admin.academy.lessons.destroy', $lesson) }}" method="POST">
      @csrf @method('DELETE')
    </form>
  </div>

  {{-- RIGHT: VIDEO --}}
  <div style="display:flex;flex-direction:column;gap:16px;position:sticky;top:80px">
    <div class="form-card">
      <div style="font-size:14px;font-weight:600;color:var(--ink);margin-bottom:4px">Video</div>
      <div style="font-size:12px;color:var(--ink3);margin-bottom:16px">Upload an MP4 video for this lesson</div>

      @if($lesson->videoAsset)
        <div style="background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px;margin-bottom:14px">
          <div style="display:flex;align-items:center;gap:10px">
            <div style="width:40px;height:40px;background:#0f172a;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">🎬</div>
            <div style="flex:1;min-width:0">
              <div style="font-size:13px;font-weight:500;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $lesson->videoAsset->label }}</div>
              <div style="font-size:11px;color:var(--ink3);font-family:'Geist Mono',monospace">{{ $lesson->videoAsset->file_size_formatted }} · {{ $lesson->duration_formatted }}</div>
            </div>
            <span class="badge badge-green">✓ Uploaded</span>
          </div>
        </div>
      @endif

      <div id="upload-zone" style="border:2px dashed var(--border-dark);border-radius:var(--radius);padding:28px 16px;text-align:center;cursor:pointer;transition:all 0.15s;background:var(--bg)" onclick="document.getElementById('video-input').click()" ondragover="event.preventDefault();this.style.borderColor='var(--accent)';this.style.background='var(--accent-light)'" ondragleave="this.style.borderColor='var(--border-dark)';this.style.background='var(--bg)'">
        <div style="font-size:28px;margin-bottom:8px">🎬</div>
        <div style="font-size:14px;font-weight:600;color:var(--ink);margin-bottom:4px">{{ $lesson->videoAsset ? 'Replace video' : 'Drop video here' }}</div>
        <div style="font-size:12px;color:var(--ink3)">or click to browse · MP4 recommended</div>
        <input type="file" id="video-input" accept="video/*" style="display:none">
      </div>

      <div id="upload-progress" style="display:none;margin-top:12px">
        <div style="display:flex;justify-content:space-between;font-size:12px;color:var(--ink3);margin-bottom:5px">
          <span id="upload-filename">Uploading...</span>
          <span id="upload-pct">0%</span>
        </div>
        <div style="height:4px;background:var(--border);border-radius:2px;overflow:hidden">
          <div id="upload-bar" style="height:100%;background:var(--accent);border-radius:2px;width:0;transition:width 0.3s"></div>
        </div>
      </div>
      <div id="upload-success" style="display:none;margin-top:12px;padding:10px 12px;background:var(--green-light);border:1px solid var(--green-border);border-radius:var(--radius-sm);font-size:13px;color:var(--green)">
        ✓ Video uploaded! Refresh to see updated details.
      </div>
    </div>
  </div>
</div>

<script>
let stepCount = {{ $lesson->steps->count() }};

function addStep() {
  const i = stepCount++;
  const num = document.querySelectorAll('#steps-list > div').length + 1;
  const div = document.createElement('div');
  div.id = 'step-new-' + i;
  div.style.cssText = 'display:flex;gap:10px;align-items:flex-start;padding:12px 14px;background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-sm)';
  div.innerHTML = `
    <div style="width:22px;height:22px;border-radius:50%;background:var(--accent-light);border:1px solid var(--accent-border);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:var(--accent);flex-shrink:0;margin-top:8px">${num}</div>
    <div style="flex:1;display:flex;flex-direction:column;gap:6px">
      <input type="text" name="steps[${i}][title]" placeholder="Step title, e.g. Navigate to Worker Profile" class="inp" style="font-size:13px;padding:7px 10px">
      <input type="text" name="steps[${i}][nav_path]" placeholder="Navigation path, e.g. Worker → Actions → Job Change" class="inp" style="font-size:12px;padding:6px 10px;color:var(--ink3)">
    </div>
    <button type="button" onclick="document.getElementById('step-new-${i}').remove()" style="background:none;border:none;cursor:pointer;color:var(--ink3);padding:6px;font-size:18px;line-height:1;margin-top:4px" onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='var(--ink3)'">×</button>
  `;
  document.getElementById('steps-list').appendChild(div);
}

function togglePublish() {
  const input = document.getElementById('pub-input');
  const track = document.getElementById('toggle-track');
  const thumb = document.getElementById('toggle-thumb');
  const label = document.getElementById('pub-label');
  const isOn = input.value === '1';
  if (isOn) {
    input.value = '0';
    track.style.background = 'var(--border-dark)';
    thumb.style.transform = 'translateX(0)';
    label.textContent = 'Draft';
  } else {
    input.value = '1';
    track.style.background = 'var(--accent)';
    thumb.style.transform = 'translateX(20px)';
    label.textContent = 'Published';
  }
}

document.getElementById('video-input').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (file) uploadVideo(file);
});

document.getElementById('upload-zone').addEventListener('drop', function(e) {
  e.preventDefault();
  this.style.borderColor = 'var(--border-dark)';
  this.style.background = 'var(--bg)';
  const file = e.dataTransfer.files[0];
  if (file) uploadVideo(file);
});

async function uploadVideo(file) {
  // Extract video duration
  const videoDuration = await new Promise((resolve) => {
    const video = document.createElement("video");
    video.preload = "metadata";
    video.onloadedmetadata = () => { window.URL.revokeObjectURL(video.src); resolve(video.duration); };
    video.onerror = () => resolve(0);
    video.src = window.URL.createObjectURL(file);
  });
  document.getElementById('upload-zone').style.display = 'none';
  document.getElementById('upload-progress').style.display = 'block';
  document.getElementById('upload-filename').textContent = file.name;
  try {
    const res = await fetch('/admin/academy/lessons/{{ $lesson->id }}/upload-url', {
      method: 'POST',
      headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content},
      body: JSON.stringify({filename: file.name, mime_type: file.type})
    });
    const { upload_url, asset_id } = await res.json();
    await new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();
      xhr.upload.addEventListener('progress', (e) => {
        if (e.lengthComputable) {
          const pct = Math.round((e.loaded / e.total) * 100);
          document.getElementById('upload-bar').style.width = pct + '%';
          document.getElementById('upload-pct').textContent = pct + '%';
        }
      });
      xhr.addEventListener('load', resolve);
      xhr.addEventListener('error', reject);
      xhr.open('PUT', upload_url);
      xhr.setRequestHeader('Content-Type', file.type);
      xhr.send(file);
    });
    await fetch('/admin/academy/lessons/{{ $lesson->id }}/confirm-upload', {
      method: 'POST',
      headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content},
      body: JSON.stringify({asset_id, file_size: file.size, duration_seconds: Math.round(videoDuration)})
    });
    document.getElementById('upload-progress').style.display = 'none';
    document.getElementById('upload-success').style.display = 'block';
  } catch(err) {
    alert('Upload failed: ' + err.message);
    document.getElementById('upload-zone').style.display = 'block';
    document.getElementById('upload-progress').style.display = 'none';
  }
}
</script>
@endsection
