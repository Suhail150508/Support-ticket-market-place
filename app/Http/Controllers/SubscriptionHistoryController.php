<?php

namespace App\Http\Controllers;
use App\Models\UserSubscription;
use App\Models\Payment;

class SubscriptionHistoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get all subscriptions with related data
        $subscriptions = UserSubscription::where('user_id', $user->id)
            ->with(['plan', 'payments'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get all payments
        $payments = Payment::where('user_id', $user->id)
            ->with(['plan', 'subscription'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get active subscription
        $activeSubscription = $user->activeSubscription;
        
        return view('user.subscription-history', compact('subscriptions', 'payments', 'activeSubscription'));
    }
}

