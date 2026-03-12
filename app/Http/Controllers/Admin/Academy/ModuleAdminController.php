<?php
namespace App\Http\Controllers\Admin\Academy;
use App\Http\Controllers\Controller;
use App\Models\Academy\Package;
use App\Models\Academy\PackageModule;
use Illuminate\Http\Request;

class ModuleAdminController extends Controller
{
    public function store(Request $request, Package $package)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'emoji_icon'  => 'nullable|string|max:10',
        ]);
        $data['sort_order'] = $package->modules()->count() + 1;
        $package->modules()->create($data);
        return back()->with('success', 'Module created!');
    }

    public function destroy(Package $package, PackageModule $module)
    {
        $module->lessons()->forceDelete();
        $module->delete();
        return back()->with('success', 'Module deleted.');
    }
}
