@extends('layouts.admin')

@section('page-title', __('Subscription Plans'))

@section('content')
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="mb-2"><i class="fas fa-credit-card me-2"></i>{{ __('Subscription Plans') }}</h1>
            <p class="mb-0 opacity-75">{{ __('Manage subscription plans for live chat access') }}</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-light btn-lg">
                <i class="fas fa-plus-circle me-2"></i>{{ __('Create New Plan') }}
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    @forelse($plans as $plan)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 {{ $plan->is_popular ? 'border-primary' : '' }}" style="{{ $plan->is_popular ? 'border-width: 2px;' : '' }}">
            @if($plan->is_popular)
            <div class="badge bg-primary position-absolute top-0 end-0 m-3">{{ __('Popular') }}</div>
            @endif
            <div class="card-body p-4">
                <h4 class="card-title mb-3">{{ $plan->name }}</h4>
                <div class="mb-3">
                    <span class="h2 fw-bold">{{ $plan->currency }} {{ number_format($plan->price, 2) }}</span>
                    <span class="text-muted">/ {{ ucfirst($plan->billing_cycle) }}</span>
                </div>
                <p class="text-muted mb-3">{{ $plan->description }}</p>
                <ul class="list-unstyled mb-4">
                    <li><i class="fas fa-check text-success me-2"></i>{{ __('Duration:') }} {{ $plan->duration_days }} {{ __('days') }}</li>
                    @if($plan->features)
                        @foreach($plan->features as $feature)
                        <li><i class="fas fa-check text-success me-2"></i>{{ $feature }}</li>
                        @endforeach
                    @endif
                </ul>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.subscriptions.edit', $plan->id) }}" class="btn btn-primary btn-sm flex-fill">
                        <i class="fas fa-edit me-2"></i>{{ __('Edit') }}
                    </a>
                    <form action="{{ route('admin.subscriptions.destroy', $plan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
                <div class="mt-3">
                    <span class="badge {{ $plan->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $plan->is_active ? __('Active') : __('Inactive') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                <p class="text-muted">{{ __('No subscription plans found. Create your first plan!') }}</p>
                <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>{{ __('Create Plan') }}
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
</style>
@endpush
@endsection