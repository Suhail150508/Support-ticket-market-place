@extends('layouts.admin')

@section('page-title', __('Edit Subscription Plan'))

@section('content')
<div class="page-header mb-4">
    <div>
        <h1 class="mb-2"><i class="fas fa-edit me-2"></i>{{ __('Edit Subscription Plan') }}</h1>
        <p class="mb-0 opacity-75">{{ __('Update subscription plan details') }}</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.subscriptions.update', $plan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('Plan Name') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ $plan->name }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('Price') }} <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control" name="price" value="{{ $plan->price }}" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('Currency') }}</label>
                    <input type="text" class="form-control" name="currency" value="{{ $plan->currency }}" maxlength="3">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('Duration (Days)') }} <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="duration_days" value="{{ $plan->duration_days }}" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('Billing Cycle') }}</label>
                    <select class="form-select" name="billing_cycle" required>
                        <option value="monthly" {{ $plan->billing_cycle === 'monthly' ? 'selected' : '' }}>{{ __('Monthly') }}</option>
                        <option value="quarterly" {{ $plan->billing_cycle === 'quarterly' ? 'selected' : '' }}>{{ __('Quarterly') }}</option>
                        <option value="yearly" {{ $plan->billing_cycle === 'yearly' ? 'selected' : '' }}>{{ __('Yearly') }}</option>
                        <option value="lifetime" {{ $plan->billing_cycle === 'lifetime' ? 'selected' : '' }}>{{ __('Lifetime') }}</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('Sort Order') }}</label>
                    <input type="number" class="form-control" name="sort_order" value="{{ $plan->sort_order }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">{{ __('Description') }}</label>
                <textarea class="form-control" name="description" rows="3">{{ $plan->description }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">{{ __('Features (One per line)') }}</label>
                <textarea class="form-control" name="features_text" rows="5">@if($plan->features){{ implode("\n", $plan->features) }}@endif</textarea>
                <small class="text-muted">{{ __('Enter one feature per line.') }}</small>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ $plan->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_popular" id="is_popular" {{ $plan->is_popular ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_popular">{{ __('Mark as Popular') }}</label>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back') }}
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>{{ __('Update Plan') }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const featuresText = document.querySelector('textarea[name="features_text"]').value;
    const features = featuresText.split('\n').filter(f => f.trim()).map(f => f.trim());
    
    const featuresInput = document.createElement('input');
    featuresInput.type = 'hidden';
    featuresInput.name = 'features';
    featuresInput.value = JSON.stringify(features);
    this.appendChild(featuresInput);
});
</script>
@endpush
@endsection