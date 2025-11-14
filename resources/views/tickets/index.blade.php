@extends('layouts.user')

@section('title', __('My Tickets'))

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="mb-2"><i class="fas fa-ticket-alt me-2"></i>{{__('My Tickets')}}</h1>
            <p class="mb-0 opacity-75">{{__('View and manage all your support tickets')}}</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('tickets.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus-circle me-2"></i>{{__('Create New Ticket')}}
            </a>
        </div>
    </div>
</div>

<!-- Status & Priority Filter -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <label class="form-label fw-semibold mb-2">{{__('Filter by Status:')}}</label>
                <select class="form-select" id="statusFilter">
                    <option value="">{{__('All Statuses')}}</option>
                    <option value="open">{{__('Open')}}</option>
                    <option value="pending">{{__('Pending')}}</option>
                    <option value="in_progress">{{__('In Progress')}}</option>
                    <option value="resolved">{{__('Resolved')}}</option>
                    <option value="closed">{{__('Closed')}}</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold mb-2">{{__('Filter by Priority:')}}</label>
                <select class="form-select" id="priorityFilter">
                    <option value="">{{__('All Priorities')}}</option>
                    <option value="low">{{__('Low')}}</option>
                    <option value="medium">{{__('Medium')}}</option>
                    <option value="high">{{__('High')}}</option>
                    <option value="urgent">{{__('Urgent')}}</option>
                </select>
            </div>
            <div class="col-md-4 text-md-end">
                <p class="text-muted mb-0">
                    <i class="fas fa-info-circle me-1"></i>
                    {{__('Showing')}} <strong>{{ $tickets->count() }}</strong> {{__('of')}} <strong>{{ $tickets->total() }}</strong> {{__('tickets')}}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Tickets Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>{{__('All Tickets')}}</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>{{__('ID')}}</th>
                        <th>{{__('Subject')}}</th>
                        <th>{{__('Category')}}</th>
                        <th>{{__('Department')}}</th>
                        <th>{{__('Priority')}}</th>
                        <th>{{__('Status')}}</th>
                        <th>{{__('Created')}}</th>
                        <th>{{__('Actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr data-status="{{ $ticket->status }}" data-priority="{{ $ticket->priority }}">
                        <td><strong>#{{ $ticket->id }}</strong></td>
                        <td><strong>{{ Str::limit($ticket->subject, 50) }}</strong></td>
                        <td>{{ ucfirst($ticket->category->name ?? __('N/A')) }}</td>
                        <td>{{ ucfirst($ticket->department->name ?? __('N/A')) }}</td>
                        <td><span class="badge bg-{{ $ticket->priority === 'urgent' ? 'danger' : ($ticket->priority === 'high' ? 'warning' : 'info') }}">{{ ucfirst($ticket->priority) }}</span></td>
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
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('{{__('Are you sure?')}}')"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">{{__('No tickets found')}}</h5>
                            <a href="{{ route('tickets.create') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus-circle me-2"></i>{{__('Create Your First Ticket')}}
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($tickets->hasPages())
    <div class="card-footer d-flex justify-content-center">
        {{ $tickets->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
document.getElementById('statusFilter').addEventListener('change', filterTickets);
document.getElementById('priorityFilter').addEventListener('change', filterTickets);

function filterTickets() {
    const status = document.getElementById('statusFilter').value;
    const priority = document.getElementById('priorityFilter').value;
    const rows = document.querySelectorAll('tbody tr[data-status]');
    rows.forEach(row => {
        const matchesStatus = !status || row.getAttribute('data-status') === status;
        const matchesPriority = !priority || row.getAttribute('data-priority') === priority;
        row.style.display = matchesStatus && matchesPriority ? '' : 'none';
    });
}
</script>
@endpush
@endsection