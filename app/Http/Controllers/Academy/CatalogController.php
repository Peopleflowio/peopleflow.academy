<?php
namespace App\Http\Controllers\Academy;
use App\Http\Controllers\Controller;
use App\Models\Academy\Package;
use App\Services\Academy\EntitlementService;
class CatalogController extends Controller
{
    public function __construct(private EntitlementService $entitlement) {}
    public function index()
    {
        $packages = Package::published()->with(['modules'])->orderBy('sort_order')->get();
        $accessibleIds = auth()->check() ? $this->entitlement->accessiblePackageIds(auth()->user()) : [];
        return view('academy.catalog', compact('packages', 'accessibleIds'));
    }
}
