@extends('layouts.user')

@section('page-title', __('Dashboard Overview'))

@section('content')
<!-- Welcome Section -->
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="mb-2">
                <i class="fas fa-tachometer-alt me-2"></i>
                {{ __('Welcome back') }}, {{ auth()->user()->name }}!
            </h1>
            <p class="mb-0 opacity-75">{{ __("Here's an overview of your support tickets and activity") }}</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('tickets.create') }}" class="btn btn-light btn-lg">
                <i class="fas fa-plus-circle me-2"></i>{{ __('Create New Ticket') }}
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-3 col-sm-6">
        <div class="stats-card stats-card-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 small fw-semibold">{{ __('Total Tickets') }}</p>
                    <h2 class="stats-number mb-0">{{ $allTickets->count() }}</h2>
                    <small class="text-muted">{{ __('All time') }}</small>
                </div>
                <div class="stats-icon bg-primary bg-opacity-10">
                    <i class="fas fa-ticket-alt fa-2x text-primary"></i>
                </div>
            </div>
            <div class="stats-footer mt-3 pt-3 border-top">
                <a href="{{ route('tickets.index') }}" class="text-decoration-none text-primary small">
                    {{ __('View All') }} <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="stats-card stats-card-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 small fw-semibold">{{ __('Open Tickets') }}</p>
                    <h2 class="stats-number mb-0 text-success">{{ $allTickets->where('status', 'open')->count() }}</h2>
                    <small class="text-muted">{{ __('Active') }}</small>
                </div>
                <div class="stats-icon bg-success bg-opacity-10">
                    <i class="fas fa-folder-open fa-2x text-success"></i>
                </div>
            </div>
            <div class="stats-footer mt-3 pt-3 border-top">
                <a href="{{ route('tickets.index') }}?status=open" class="text-decoration-none text-success small">
                    {{ __('View Open') }} <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="stats-card stats-card-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 small fw-semibold">{{ __('Pending Tickets') }}</p>
                    <h2 class="stats-number mb-0 text-warning">{{ $allTickets->where('status', 'pending')->count() }}</h2>
                    <small class="text-muted">{{ __('Awaiting') }}</small>
                </div>
                <div class="stats-icon bg-warning bg-opacity-10">
                    <i class="fas fa-clock fa-2x text-warning"></i>
                </div>
            </div>
            <div class="stats-footer mt-3 pt-3 border-top">
                <a href="{{ route('tickets.index') }}?status=pending" class="text-decoration-none text-warning small">
                    {{ __('View Pending') }} <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="stats-card stats-card-secondary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 small fw-semibold">{{ __('Closed Tickets') }}</p>
                    <h2 class="stats-number mb-0 text-secondary">{{ $allTickets->where('status', 'closed')->count() }}</h2>
                    <small class="text-muted">{{ __('Resolved') }}</small>
                </div>
                <div class="stats-icon bg-secondary bg-opacity-10">
                    <i class="fas fa-check-circle fa-2x text-secondary"></i>
                </div>
            </div>
            <div class="stats-footer mt-3 pt-3 border-top">
                <a href="{{ route('tickets.index') }}?status=closed" class="text-decoration-none text-secondary small">
                    {{ __('View Closed') }} <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Tickets -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-clock me-2"></i>{{ __('Recent Tickets') }}</h5>
        <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-light">{{ __('View All') }}</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Subject') }}</th>
                        <th>{{ __('Priority') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Created') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTickets->take(10) as $ticket)
                    <tr>
                        <td><strong>#{{ $ticket->id }}</strong></td>
                        <td>{{ Str::limit($ticket->subject, 50) }}</td>
                        <td>
                            <span class="badge bg-{{ $ticket->priority === 'urgent' ? 'danger' : ($ticket->priority === 'high' ? 'warning' : 'info') }}">
                                {{ __(ucfirst($ticket->priority)) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge 
                                @if($ticket->status === 'open') bg-success
                                @elseif($ticket->status === 'pending') bg-warning
                                @elseif($ticket->status === 'closed') bg-secondary
                                @else bg-primary @endif">
                                {{ __(ucfirst($ticket->status)) }}
                            </span>
                        </td>
                        <td><small>{{ $ticket->created_at->format('M d, Y H:i') }}</small></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-info" title="{{ __('View') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning" title="{{ __('Edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">{{ __('No tickets found. Create your first ticket!') }}</p>
                            <a href="{{ route('tickets.create') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus-circle me-2"></i>{{ __('Create Ticket') }}
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
