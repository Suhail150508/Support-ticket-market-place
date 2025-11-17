@extends('layouts.user')

@section('page-title', __('Subscription History'))

@section('content')
<!-- Active Subscription Card -->
@if($activeSubscription)
<div class="card mb-4 border-success">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">
            <i class="fas fa-check-circle me-2"></i>{{ __('Active Subscription') }}
        </h5>
    </div>
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="mb-2">{{ $activeSubscription->plan->name }}</h4>
                <p class="text-muted mb-2">{{ $activeSubscription->plan->description }}</p>
                <div class="d-flex gap-4 mb-2">
                    <div>
                        <small class="text-muted d-block">{{ __('Started') }}</small>
                        <strong>{{ $activeSubscription->starts_at->format('M d, Y') }}</strong>
                    </div>
                    <div>
                        <small class="text-muted d-block">{{ __('Expires') }}</small>
                        <strong>{{ $activeSubscription->ends_at->format('M d, Y') }}</strong>
                    </div>
                    <div>
                        <small class="text-muted d-block">{{ __('Days Remaining') }}</small>
                        <strong class="text-success">{{ $activeSubscription->daysRemaining() }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <span class="badge bg-success fs-6 px-3 py-2 mb-2 d-inline-block">
                    {{ __('Active') }}
                </span>
                <div>
                    <strong class="text-success fs-4">{{ $activeSubscription->plan->currency }}{{ number_format($activeSubscription->plan->price, 2) }}</strong>
                    <small class="text-muted">/{{ ucfirst($activeSubscription->plan->billing_cycle) }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-info mb-4">
    <i class="fas fa-info-circle me-2"></i>
    {{ __('You don\'t have an active subscription.') }}
    <a href="{{ route('subscriptions.index') }}" class="alert-link">{{ __('View Plans') }}</a>
</div>
@endif

<!-- Subscription History -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-history me-2"></i>{{ __('Subscription History') }}
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Plan') }}</th>
                        <th>{{ __('Start Date') }}</th>
                        <th>{{ __('End Date') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions as $subscription)
                    <tr>
                        <td>
                            <strong>{{ $subscription->plan->name }}</strong>
                            @if($subscription->isActive())
                                <span class="badge bg-success ms-2">{{ __('Active') }}</span>
                            @elseif($subscription->isExpired())
                                <span class="badge bg-secondary ms-2">{{ __('Expired') }}</span>
                            @else
                                <span class="badge bg-{{ $subscription->status === 'cancelled' ? 'danger' : 'warning' }} ms-2">
                                    {{ ucfirst($subscription->status) }}
                                </span>
                            @endif
                        </td>
                        <td>{{ $subscription->starts_at->format('M d, Y') }}</td>
                        <td>{{ $subscription->ends_at->format('M d, Y') }}</td>
                        <td>
                            @if($subscription->isActive())
                                <span class="badge bg-success">{{ __('Active') }}</span>
                            @elseif($subscription->isExpired())
                                <span class="badge bg-secondary">{{ __('Expired') }}</span>
                            @else
                                <span class="badge bg-{{ $subscription->status === 'cancelled' ? 'danger' : 'warning' }}">
                                    {{ ucfirst($subscription->status) }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $subscription->plan->currency }}{{ number_format($subscription->plan->price, 2) }}</strong>
                        </td>
                        <td>
                            @if($subscription->payments->count() > 0)
                                <button class="btn btn-sm btn-info" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#paymentModal{{ $subscription->id }}">
                                    <i class="fas fa-receipt"></i> {{ __('View Payment') }}
                                </button>
                            @endif
                        </td>
                    </tr>

                    <!-- Payment Modal -->
                    @if($subscription->payments->count() > 0)
                    <div class="modal fade" id="paymentModal{{ $subscription->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('Payment Details') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    @foreach($subscription->payments as $payment)
                                    <div class="mb-3 pb-3 border-bottom">
                                        <div class="row">
                                            <div class="col-6">
                                                <small class="text-muted d-block">{{ __('Transaction ID') }}</small>
                                                <strong>{{ $payment->transaction_id }}</strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small class="text-muted d-block">{{ __('Amount') }}</small>
                                                <strong>{{ $payment->currency }}{{ number_format($payment->amount, 2) }}</strong>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <small class="text-muted d-block">{{ __('Payment Method') }}</small>
                                                <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small class="text-muted d-block">{{ __('Status') }}</small>
                                                <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($payment->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <small class="text-muted d-block">{{ __('Date') }}</small>
                                                <span>{{ $payment->created_at->format('M d, Y H:i') }}</span>
                                            </div>
                                        </div>
                                        @if($payment->notes)
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <small class="text-muted d-block">{{ __('Notes') }}</small>
                                                <p class="mb-0">{{ $payment->notes }}</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">{{ __('No subscription history found.') }}</p>
                            <a href="{{ route('subscriptions.index') }}" class="btn btn-primary">
                                <i class="fas fa-credit-card me-2"></i>{{ __('View Subscription Plans') }}
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Payment History -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-receipt me-2"></i>{{ __('Payment History') }}
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Transaction ID') }}</th>
                        <th>{{ __('Plan') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Payment Method') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td><strong>{{ $payment->transaction_id }}</strong></td>
                        <td>{{ $payment->plan->name ?? __('N/A') }}</td>
                        <td>
                            <strong>{{ $payment->currency }}{{ number_format($payment->amount, 2) }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-info">
                                {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : ($payment->status === 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">{{ __('No payment history found.') }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

