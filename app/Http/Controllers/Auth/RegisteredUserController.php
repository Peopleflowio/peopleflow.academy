<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Referral;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
class RegisteredUserController extends Controller
{
    public function create(): View
    {
        if (request()->has('intended')) {
            session(['url.intended' => request()->get('intended')]);
        }
        if (request()->has('ref')) {
            session(['referral_code' => request()->get('ref')]);
        }
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'learner',
        ]);
        event(new Registered($user));
        Auth::login($user);

        // Track referral
        $refCode = $request->input('ref') ?? session('referral_code');
        if ($refCode) {
            $referrer = User::where('referral_code', $refCode)->first();
            if ($referrer && $referrer->id !== $user->id) {
                Referral::create([
                    'referrer_id' => $referrer->id,
                    'referred_id' => $user->id,
                    'code' => $refCode,
                    'status' => 'pending',
                    'reward_cents' => 0,
                ]);
                session()->forget('referral_code');
            }
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
