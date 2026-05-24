<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\PayoutRequest;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        $payouts = PayoutRequest::with('user')->latest()->get();
        return view('admin.settings', compact('settings', 'payouts'));
    }

    public function update(Request $request)
    {
        foreach ($request->settings as $key => $value) {
            Setting::set($key, $value);
        }
        return back()->with('success', 'Settings saved!');
    }

    public function updatePayout(Request $request, PayoutRequest $payout)
    {
        $payout->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'paid_at' => $request->status === 'paid' ? now() : null,
        ]);
        return back()->with('success', 'Payout updated!');
    }
}
