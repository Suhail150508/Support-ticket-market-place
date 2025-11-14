<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::orderBy('sort_order')->get();
        return view('admin.subscriptions.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.subscriptions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'duration_days' => 'required|integer|min:1',
            'billing_cycle' => 'required|in:monthly,quarterly,yearly,lifetime',
            'features' => 'nullable|array',
            'is_active' => 'boolean',
            'is_popular' => 'boolean',
            'sort_order' => 'integer'
        ]);

        SubscriptionPlan::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'currency' => $request->currency,
            'duration_days' => $request->duration_days,
            'billing_cycle' => $request->billing_cycle,
            'features' => $request->features ?? [],
            'is_active' => $request->has('is_active'),
            'is_popular' => $request->has('is_popular'),
            'sort_order' => $request->sort_order ?? 0
        ]);

        session()->flash('success', 'Subscription plan created successfully');
        return redirect()->route('admin.subscriptions.index');
    }

    public function edit($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        return view('admin.subscriptions.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'duration_days' => 'required|integer|min:1',
            'billing_cycle' => 'required|in:monthly,quarterly,yearly,lifetime',
            'features' => 'nullable|array',
            'is_active' => 'boolean',
            'is_popular' => 'boolean',
            'sort_order' => 'integer'
        ]);

        $plan->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'currency' => $request->currency,
            'duration_days' => $request->duration_days,
            'billing_cycle' => $request->billing_cycle,
            'features' => $request->features ?? [],
            'is_active' => $request->has('is_active'),
            'is_popular' => $request->has('is_popular'),
            'sort_order' => $request->sort_order ?? 0
        ]);

        session()->flash('success', 'Subscription plan updated successfully');
        return redirect()->route('admin.subscriptions.index');
    }

    public function destroy($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $plan->delete();

        session()->flash('success', 'Subscription plan deleted successfully');
        return redirect()->route('admin.subscriptions.index');
    }
}
