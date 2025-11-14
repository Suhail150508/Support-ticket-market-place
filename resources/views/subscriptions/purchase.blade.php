@extends('layouts.user')

@section('page-title', __('Purchase Subscription'))

@section('content')
<div class="page-header mb-4">
    <div>
        <h1 class="mb-2">
            <i class="fas fa-shopping-cart me-2"></i>{{ __('Purchase Subscription') }}
        </h1>
        <p class="mb-0 opacity-75">{{ __('Complete your subscription purchase') }}</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>{{ __('Plan Details') }}</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>{{ $plan->name }}</h4>
                    <span class="h3 text-primary fw-bold">{{ $plan->currency }} {{ number_format($plan->price, 2) }}</span>
                </div>
                <p class="text-muted">{{ $plan->description }}</p>
                <ul class="list-unstyled">
                    <li>
                        <i class="fas fa-check text-success me-2"></i>
                        {{ __('Duration') }}: {{ $plan->duration_days }} {{ __('days') }}
                    </li>
                    <li>
                        <i class="fas fa-check text-success me-2"></i>
                        {{ __('Billing Cycle') }}: {{ __(ucfirst($plan->billing_cycle)) }}
                    </li>
                    @if($plan->features)
                        @foreach($plan->features as $feature)
                        <li><i class="fas fa-check text-success me-2"></i>{{ __($feature) }}</li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>{{ __('Payment Method') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('subscriptions.payment', $plan->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('Select Payment Method') }}</label>
                        <select class="form-select" name="payment_method" required>
                            <option value="free">{{ __('Free (For Testing)') }}</option>
                            <option value="manual">{{ __('Manual Payment') }}</option>
                            <option value="bank_transfer">{{ __('Bank Transfer') }}</option>
                            <option value="stripe" disabled>{{ __('Stripe (Coming Soon)') }}</option>
                            <option value="paypal" disabled>{{ __('PayPal (Coming Soon)') }}</option>
                        </select>
                        <small class="text-muted">
                            {{ __('Note: For production, integrate with payment gateways like Stripe or PayPal') }}
                        </small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('Notes (Optional)') }}</label>
                        <textarea class="form-control" name="notes" rows="3" placeholder="{{ __('Any additional notes...') }}"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('subscriptions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>{{ __('Back') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check me-2"></i>{{ __('Complete Purchase') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>{{ __('Order Summary') }}</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <span>{{ __('Plan') }}:</span>
                    <strong>{{ $plan->name }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>{{ __('Duration') }}:</span>
                    <strong>{{ $plan->duration_days }} {{ __('days') }}</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <span class="h5">{{ __('Total') }}:</span>
                    <span class="h5 text-primary fw-bold">{{ $plan->currency }} {{ number_format($plan->price, 2) }}</span>
                </div>
                <div class="alert alert-info small mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ __("After payment, you'll get immediate access to live chat with admin support.") }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
