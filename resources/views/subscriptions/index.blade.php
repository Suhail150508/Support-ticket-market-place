@extends('layouts.user')

@section('page-title', __('Subscription Plans'))

@push('styles')

@endpush

@section('content')
<div class="page-header mb-4">
    <div>
        <h1 class="mb-2"><i class="fas fa-credit-card me-2"></i>{{__('Subscription Plans')}}</h1>
        <p class="mb-0 opacity-75">{{__('Choose a plan to access live chat with admin support')}}</p>
    </div>
</div>

@if($activeSubscription)
<div class="alert alert-success mb-4">
    <i class="fas fa-check-circle me-2"></i>
    <strong>{{__('Active Subscription:')}}</strong> {{__('You have an active subscription until')}} {{ $activeSubscription->ends_at->format('M d, Y') }} 
    ({{ $activeSubscription->daysRemaining() }} {{__('days remaining')}})
    <a href="{{ route('subscriptions.my') }}" class="btn btn-sm btn-light ms-3">{{__('View Details')}}</a>
</div>
@endif

<div class="row g-4 justify-content-center">
    @forelse($plans as $plan)
    <div class="col-md-6 col-lg-4">
        <div class="subscription-package-card h-100 {{ $plan->is_popular ? 'popular-plan' : '' }}" data-plan-id="{{ $plan->id }}">
            @if($plan->is_popular)
            <div class="popular-badge">
                <i class="fas fa-star me-1"></i>{{__('Most Popular')}}
            </div>
            @endif
            <div class="package-header">
                <div class="package-icon">
                    <i class="fas fa-{{ $plan->is_popular ? 'crown' : 'gem' }}"></i>
                </div>
                <h3 class="package-name">{{ $plan->name }}</h3>
            </div>
            <div class="package-price">
                <span class="currency">{{ $plan->currency }}</span>
                <span class="amount">{{ number_format($plan->price, 0) }}</span>
                <span class="period">/{{ ucfirst($plan->billing_cycle) }}</span>
            </div>
            <p class="package-description">{{ $plan->description }}</p>
            <div class="package-features">
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>{{__('Live Chat Access')}}</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ $plan->duration_days }} {{__('Days Access')}}</span>
                </div>
                @if($plan->features)
                    @foreach($plan->features as $feature)
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ $feature }}</span>
                    </div>
                    @endforeach
                @endif
            </div>
            <a href="{{ route('subscriptions.purchase', $plan->id) }}" class="package-btn {{ $plan->is_popular ? 'btn-popular' : '' }}">
                <span>{{__('Purchase Now')}}</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                <p class="text-muted">{{__('No subscription plans available at the moment.')}}</p>
            </div>
        </div>
    </div>
    @endforelse
</div>

@endsection