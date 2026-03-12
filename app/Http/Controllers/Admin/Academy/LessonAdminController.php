<?php
namespace App\Http\Controllers\Admin\Academy;
use App\Http\Controllers\Controller;
use App\Models\Academy\{Package, PackageModule, Lesson, LessonAsset};
use App\Services\Academy\ContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LessonAdminController extends Controller
{
    public function __construct(private ContentService $content) {}

    public function index()
    {
        $packages = Package::with(['modules.lessons.assets'])->get();
        return view('admin.academy.lessons.index', compact('packages'));
    }

    public function create(Request $request)
    {
        $packages = Package::with('modules')->orderBy('sort_order')->get();
        $module   = $request->module_id ? PackageModule::findOrFail($request->module_id) : null;
        return view('admin.academy.lessons.create', compact('packages', 'module'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'module_id'    => 'required|exists:package_modules,id',
            'title'        => 'required|string|max:200',
            'description'  => 'nullable|string',
            'process_type' => 'required|in:staffing,org,compensation,reporting,other',
            'difficulty'   => 'required|in:beginner,intermediate,advanced',
           'is_published' => 'nullable|in:0,1',
            'steps'            => 'nullable|array',
            'steps.*.title'    => 'required_with:steps|string|max:255',
            'steps.*.nav_path' => 'nullable|string|max:500',
        ]);
        $data['is_published'] = $request->input('is_published', '0') === '1';
        $module = PackageModule::findOrFail($data['module_id']);
        $lesson = $this->content->createLesson($module, Arr::except($data, ['steps']));
        if (!empty($data['steps'])) $this->content->syncSteps($lesson, $data['steps']);
        return redirect()->route('admin.academy.lessons.edit', $lesson)->with('success', 'Lesson created!');
    }

    public function edit(Lesson $lesson)
    {
        $lesson->load(['steps', 'assets', 'module.package']);
        $packages = Package::with('modules')->get();
        return view('admin.academy.lessons.edit', compact('lesson', 'packages'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $data = $request->validate([
            'module_id'    => 'required|exists:package_modules,id',
            'title'        => 'required|string|max:200',
            'description'  => 'nullable|string',
            'process_type' => 'required|in:staffing,org,compensation,reporting,other',
            'difficulty'   => 'required|in:beginner,intermediate,advanced',
            'is_published' => 'nullable|in:0,1',
            'steps'            => 'nullable|array',
            'steps.*.title'    => 'required_with:steps|string|max:255',
            'steps.*.nav_path' => 'nullable|string|max:500',
        ]);
         $data['is_published'] = $request->input('is_published', '0') === '1';
        $this->content->updateLesson($lesson, Arr::except($data, ['steps']));
        if (array_key_exists('steps', $data)) $this->content->syncSteps($lesson, $data['steps'] ?? []);
        return back()->with('success', 'Lesson saved.');
    }

    public function destroy(Lesson $lesson)
    {
        $this->content->deleteLesson($lesson);
        return redirect()->route('admin.academy.lessons.index')->with('success', 'Lesson deleted.');
    }

    public function getUploadUrl(Request $request, Lesson $lesson)
    {
        $data = $request->validate(['filename' => 'required|string', 'mime_type' => 'required|string']);
        $result = $this->content->initiateVideoUpload($lesson, $data['filename'], $data['mime_type']);
        return response()->json($result);
    }

    public function confirmUpload(Request $request, Lesson $lesson)
    {
        $data = $request->validate(['asset_id' => 'required|integer', 'file_size' => 'required|integer']);
        $asset = LessonAsset::findOrFail($data['asset_id']);
        $this->content->confirmVideoUpload($asset, $data['file_size']);
        return response()->json(['ok' => true]);
    }
}
