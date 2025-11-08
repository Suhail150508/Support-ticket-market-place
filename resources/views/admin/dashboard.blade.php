@extends('layouts.admin')

@section('page-title', 'Dashboard Overview')

@section('content')
<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 small">Total Tickets</p>
                    <h2 class="stats-number mb-0">{{ $allTickets->count() }}</h2>
                </div>
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                    <i class="fas fa-ticket-alt fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 small">Open Tickets</p>
                    <h2 class="stats-number mb-0 text-success">{{ $allTickets->where('status', 'open')->count() }}</h2>
                </div>
                <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                    <i class="fas fa-folder-open fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 small">Pending Tickets</p>
                    <h2 class="stats-number mb-0 text-warning">{{ $allTickets->where('status', 'pending')->count() }}</h2>
                </div>
                <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                    <i class="fas fa-clock fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 small">Closed Tickets</p>
                    <h2 class="stats-number mb-0 text-secondary">{{ $allTickets->where('status', 'closed')->count() }}</h2>
                </div>
                <div class="bg-secondary bg-opacity-10 p-3 rounded-circle">
                    <i class="fas fa-check-circle fa-2x text-secondary"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center p-4">
                <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                    <i class="fas fa-list fa-3x text-primary"></i>
                </div>
                <h5 class="mb-3">Manage Tickets</h5>
                <p class="text-muted mb-3">View and manage all support tickets</p>
                <a href="{{ route('admin.tickets.index') }}" class="btn btn-primary">
                    <i class="fas fa-ticket-alt me-2"></i>View All Tickets
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center p-4">
                <div class="bg-success bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                    <i class="fas fa-plus-circle fa-3x text-success"></i>
                </div>
                <h5 class="mb-3">Create Ticket</h5>
                <p class="text-muted mb-3">Create a new ticket for a user</p>
                <a href="{{ route('admin.tickets.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Create Ticket
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center p-4">
                <div class="bg-info bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                    <i class="fas fa-users fa-3x text-info"></i>
                </div>
                <h5 class="mb-3">Manage Users</h5>
                <p class="text-muted mb-3">View and manage system users</p>
                <a href="{{ route('admin.users.index') }}" class="btn btn-info">
                    <i class="fas fa-users me-2"></i>View Users
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Tickets -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Tickets</h5>
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-sm btn-light">View All</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Subject</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets->take(10) as $ticket)
                    <tr>
                        <td><strong>#{{ $ticket->id }}</strong></td>
                        <td>{{ Str::limit($ticket->subject, 50) }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $ticket->user->name }}</div>
                                    <small class="text-muted">{{ $ticket->user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge 
                                @if($ticket->status === 'open') bg-success
                                @elseif($ticket->status === 'pending') bg-warning
                                @elseif($ticket->status === 'closed') bg-secondary
                                @else bg-primary @endif">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </td>
                        <td><small>{{ $ticket->created_at->format('M d, Y H:i') }}</small></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="" class="btn btn-warning" title="Edit">
                                {{-- <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn btn-warning" title="Edit"> --}}
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No tickets found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
