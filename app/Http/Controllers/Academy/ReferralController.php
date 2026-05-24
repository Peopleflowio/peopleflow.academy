<?php
namespace App\Http\Controllers\Academy;
use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\PayoutRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $referralCode = $user->referral_code;
        $referralLink = url('/register?ref=' . $referralCode);
        
        $referrals = Referral::where('referrer_id', $user->id)->with('referred')->latest()->get();
        $totalReferrals = $referrals->count();
        $converted = $referrals->where('status', 'converted')->count();
        $totalEarned = $referrals->where('status', 'converted')->sum('reward_cents');
        $paidOut = PayoutRequest::where('user_id', $user->id)->where('status', 'paid')->sum('amount_cents');
        $pendingPayout = max(0, $totalEarned - $paidOut);
        $payoutRequests = PayoutRequest::where('user_id', $user->id)->latest()->get();

        return view('academy.referrals', compact(
            'referralCode', 'referralLink', 'referrals',
            'totalReferrals', 'converted', 'totalEarned',
            'pendingPayout', 'payoutRequests'
        ));
    }

    public function requestPayout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'payment_details' => 'required|string',
        ]);

        $user = auth()->user();
        $totalEarned = Referral::where('referrer_id', $user->id)->where('status', 'converted')->sum('reward_cents');
        $alreadyPaid = PayoutRequest::where('user_id', $user->id)->where('status', 'paid')->sum('amount_cents');
        $available = $totalEarned - $alreadyPaid;

        if ($available <= 0) {
            return back()->with('error', 'No balance available for payout.');
        }

        // Check if there's already a pending request
        $existingPending = PayoutRequest::where('user_id', $user->id)->where('status', 'pending')->exists();
        if ($existingPending) {
            return back()->with('error', 'You already have a pending payout request. Please wait for it to be processed.');
        }

        PayoutRequest::create([
            'user_id' => $user->id,
            'amount_cents' => $available,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'payment_details' => $request->payment_details,
        ]);

        return back()->with('success', 'Payout request submitted! We will process it within 5 business days.');
    }
}
