@extends('layouts.admin')

@section('page-title', 'Ticket Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0"><i class="fas fa-ticket-alt me-2"></i>All Tickets</h2>
        <p class="text-muted mb-0">Manage all support tickets</p>
    </div>
    <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle me-2"></i>Create New Ticket
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.tickets.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search by ID, subject, or message..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-2"></i>Filter
                </button>
                <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tickets Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Tickets List</h5>
        <span class="badge bg-primary">{{ $tickets->total() }} Total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Subject</th>
                        <th>User</th>
                        <th>Department</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Assigned</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr>
                        <td><strong>#{{ $ticket->id }}</strong></td>
                        <td>
                            <strong>{{ Str::limit($ticket->subject, 50) }}</strong>
                            @if($ticket->message)
                                <br><small class="text-muted">{{ Str::limit($ticket->message, 60) }}</small>
                            @endif
                        </td>
                        <td>{{ $ticket->user->name }}</td>
                        <td>{{ $ticket->department?->name ?? '-' }}</td>
                        <td>{{ $ticket->category?->name ?? '-' }}</td>
                        <td>
                            <span class="badge 
                                @if($ticket->priority === 'low') bg-secondary
                                @elseif($ticket->priority === 'medium') bg-info
                                @elseif($ticket->priority === 'high') bg-warning
                                @elseif($ticket->priority === 'urgent') bg-danger
                                @else bg-light text-dark @endif">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge 
                                @if($ticket->status === 'open') bg-success
                                @elseif($ticket->status === 'pending') bg-warning
                                @elseif($ticket->status === 'in_progress') bg-primary
                                @elseif($ticket->status === 'resolved') bg-info
                                @elseif($ticket->status === 'closed') bg-secondary
                                @else bg-light text-dark @endif">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </td>
                        <td>{{ $ticket->assignedTo?->name ?? '-' }}</td>
                        <td><small>{{ $ticket->created_at->format('M d, Y H:i') }}</small></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this ticket?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No tickets found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($tickets->hasPages())
    <div class="card-footer">
        <div class="d-flex justify-content-center">
            {{ $tickets->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
