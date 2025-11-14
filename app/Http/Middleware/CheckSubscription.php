<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to access this feature.');
        }

        $user = auth()->user();

        // Admins can always access
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Check if user has active subscription
        if (!$user->canAccessChat()) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'You need an active subscription to access live chat. Please purchase a subscription plan.');
        }

        return $next($request);
    }
}
