<?php
namespace App\Http\Controllers\Academy;
use App\Http\Controllers\Controller;
use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $referralCode = $user->referral_code;
        $referralLink = url('/register?ref=' . $referralCode);
        
        $referrals = Referral::where('referrer_id', $user->id)
            ->with('referred')
            ->latest()
            ->get();

        $totalReferrals = $referrals->count();
        $converted = $referrals->where('status', 'converted')->count();
        $totalEarned = $referrals->sum('reward_cents');

        return view('academy.referrals', compact(
            'referralCode', 'referralLink', 'referrals',
            'totalReferrals', 'converted', 'totalEarned'
        ));
    }
}
