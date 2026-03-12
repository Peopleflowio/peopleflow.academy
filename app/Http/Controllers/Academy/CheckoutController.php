<?php
namespace App\Http\Controllers\Academy;
use App\Http\Controllers\Controller;
use App\Models\Academy\Package;
use App\Models\Purchase;
use App\Models\SeatLicense;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    public function checkout(Request $request, Package $package)
    {
        // Check if already enrolled
        $userId = auth()->id();
        $existing = SeatLicense::where('user_id', $userId)->where('package_id', $package->id)->first();
        if ($existing) {
            return redirect()->route('academy.package', $package->slug)->with('info', 'You are already enrolled in this course.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $package->title,
                        'description' => $package->description ?? 'Peopleflow Academy Course',
                    ],
                    'unit_amount' => $package->price_cents,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('academy.checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('home'),
            'metadata' => [
                'package_id' => $package->id,
                'user_id' => $userId,
            ],
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::retrieve($request->session_id);

        if ($session->payment_status === 'paid') {
            $packageId = $session->metadata->package_id;
            $userId = $session->metadata->user_id;

            $existing = Purchase::where('stripe_checkout_session_id', $session->id)->first();
            if (!$existing) {
                $purchase = Purchase::create([
                    'package_id' => $packageId,
                    'organization_id' => auth()->user()->organization_id ?? 1,
                    'amount_cents' => $session->amount_total,
                    'currency' => 'usd',
                    'stripe_checkout_session_id' => $session->id,
                    'status' => 'paid',
                    'paid_at' => now(),
                    'seat_count' => 1,
                ]);

                SeatLicense::firstOrCreate([
                    'user_id' => $userId,
                    'package_id' => $packageId,
                ], [
                    'purchase_id' => $purchase->id,
                    'organization_id' => auth()->user()->organization_id ?? 1,
                    'assigned_at' => now(),
                ]);
            }
        }

        \Illuminate\Support\Facades\Mail::to(auth()->user()->email)->send(new \App\Mail\EnrollmentConfirmation(auth()->user(), \App\Models\Academy\Package::find($packageId)));
        return redirect()->route('academy.dashboard')->with('success', 'Enrollment successful! Your course is now unlocked.');
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $packageId = $session->metadata->package_id;
            $userId = $session->metadata->user_id;

            $existing = Purchase::where('stripe_checkout_session_id', $session->id)->first();
            if (!$existing) {
                $purchase = Purchase::create([
                    'package_id' => $packageId,
                    'organization_id' => null,
                    'amount_cents' => $session->amount_total,
                    'currency' => 'usd',
                    'stripe_checkout_session_id' => $session->id,
                    'status' => 'paid',
                    'paid_at' => now(),
                    'seat_count' => 1,
                ]);

                SeatLicense::firstOrCreate([
                    'user_id' => $userId,
                    'package_id' => $packageId,
                ], [
                    'purchase_id' => $purchase->id,
                    'organization_id' => auth()->user()->organization_id ?? 1,
                    'assigned_at' => now(),
                ]);
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
