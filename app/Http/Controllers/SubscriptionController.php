<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        $activeSubscription = auth()->user()->activeSubscription;
        
        return view('subscriptions.index', compact('plans', 'activeSubscription'));
    }

    public function purchase($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        
        if (!$plan->is_active) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'This subscription plan is not available.');
        }

        return view('subscriptions.purchase', compact('plan'));
    }

    public function processPayment(Request $request, $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        
        $request->validate([
            'payment_method' => 'required|in:stripe,paypal,bank_transfer,manual,free',
            'notes' => 'nullable|string'
        ]);

        // Create payment record
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'subscription_plan_id' => $plan->id,
            'transaction_id' => 'TXN-' . time() . '-' . auth()->id(),
            'amount' => $plan->price,
            'currency' => $plan->currency,
            'payment_method' => $request->payment_method,
            'status' => $request->payment_method === 'free' ? 'completed' : 'pending',
            'notes' => $request->notes
        ]);

        // If payment is free or completed, create subscription immediately
        if ($request->payment_method === 'free' || $request->payment_method === 'manual') {
            // Cancel any existing active subscription
            UserSubscription::where('user_id', auth()->id())
                ->where('status', 'active')
                ->update(['status' => 'cancelled']);

            // Create new subscription
            $subscription = UserSubscription::create([
                'user_id' => auth()->id(),
                'subscription_plan_id' => $plan->id,
                'starts_at' => now(),
                'ends_at' => now()->addDays($plan->duration_days),
                'status' => 'active',
                'auto_renew' => false
            ]);

            $payment->update([
                'user_subscription_id' => $subscription->id,
                'status' => 'completed'
            ]);

            session()->flash('success', 'Subscription activated successfully! You can now access live chat.');
            return redirect()->route('chat.index');
        }

        // For other payment methods, redirect to payment processing
        session()->flash('info', 'Payment is being processed. Your subscription will be activated once payment is confirmed.');
        return redirect()->route('subscriptions.index');
    }

    public function mySubscription()
    {
        $subscriptions = auth()->user()->subscriptions()
            ->with('plan')
            ->latest()
            ->get();
        
        $activeSubscription = auth()->user()->activeSubscription;
        
        return view('subscriptions.my-subscription', compact('subscriptions', 'activeSubscription'));
    }
}
