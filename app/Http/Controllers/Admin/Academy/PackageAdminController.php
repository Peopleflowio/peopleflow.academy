<?php
namespace App\Http\Controllers\Admin\Academy;
use App\Http\Controllers\Controller;
use App\Models\Academy\{Package, PackageModule};
use App\Services\Academy\ContentService;
use Illuminate\Http\Request;
class PackageAdminController extends Controller
{
    public function __construct(private ContentService $content) {}
    public function index()
    {
        $packages = Package::withCount(['modules','lessons'])->orderBy('sort_order')->get();
        return view('admin.academy.packages.index', compact('packages'));
    }
    public function create()
    {
        return view('admin.academy.packages.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:200',
            'description'  => 'nullable|string',
            'emoji_icon'   => 'nullable|string|max:10',
            'price_cents'  => 'required|integer|min:0',
            'is_published' => 'nullable|boolean',
        ]);
        $package = $this->content->createPackage($data);
        return redirect()->route('admin.academy.packages.edit', $package)->with('success', 'Package created!');
    }
    public function edit(Package $package)
    {
        $package->load(['modules.lessons.assets']);
        return view('admin.academy.packages.edit', compact('package'));
    }
    public function update(Request $request, Package $package)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:200',
            'description'  => 'nullable|string',
            'emoji_icon'   => 'nullable|string|max:10',
            'price_cents'  => 'required|integer|min:0',
            'is_published' => 'nullable|boolean',
        ]);
        $this->content->updatePackage($package, $data);
        return back()->with('success', 'Package updated.');
    }
    public function destroy(Package $package)
    {
        $this->content->deletePackage($package);
        return redirect()->route('admin.academy.packages.index')->with('success', 'Package deleted.');
    }
}
