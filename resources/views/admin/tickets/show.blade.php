@extends('layouts.admin')

@section('page-title', 'Ticket #' . $ticket->id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.tickets.index') }}">Tickets</a></li>
                <li class="breadcrumb-item active">Ticket #{{ $ticket->id }}</li>
            </ol>
        </nav>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this ticket?')">
                <i class="fas fa-trash me-2"></i>Delete
            </button>
        </form>
    </div>
</div>

<!-- Ticket Details -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0"><i class="fas fa-ticket-alt me-2"></i>{{ $ticket->subject }}</h5>
            <small class="text-white opacity-75">
                <i class="fas fa-user me-1"></i>{{ $ticket->user->name }} 
                <span class="ms-3"><i class="fas fa-calendar me-1"></i>{{ $ticket->created_at->format('M d, Y H:i') }}</span>
            </small>
        </div>
        <span class="badge 
            @if($ticket->status === 'open') bg-success
            @elseif($ticket->status === 'pending') bg-warning
            @elseif($ticket->status === 'in_progress') bg-primary
            @elseif($ticket->status === 'resolved') bg-info
            @elseif($ticket->status === 'closed') bg-secondary
            @else bg-light text-dark @endif badge-lg">
            {{ ucfirst($ticket->status) }}
        </span>
    </div>
    <div class="card-body p-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <small class="text-muted d-block mb-1">Department</small>
                <strong>{{ $ticket->department?->name ?? '-' }}</strong>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block mb-1">Category</small>
                <strong>{{ $ticket->category?->name ?? '-' }}</strong>
            </div>
            <div class="col-md-6 mt-3">
                <small class="text-muted d-block mb-1">Priority</small>
                <span class="badge 
                    @if($ticket->priority === 'low') bg-secondary
                    @elseif($ticket->priority === 'medium') bg-info
                    @elseif($ticket->priority === 'high') bg-warning
                    @elseif($ticket->priority === 'urgent') bg-danger
                    @else bg-light text-dark @endif">
                    {{ ucfirst($ticket->priority) }}
                </span>
            </div>
            <div class="col-md-6 mt-3">
                <small class="text-muted d-block mb-1">Assigned To</small>
                <strong>{{ $ticket->assignedTo?->name ?? '-' }}</strong>
            </div>
        </div>

        <hr>

        <div class="mb-3">
            <h6 class="fw-semibold mb-2"><i class="fas fa-file-alt me-2"></i>Description</h6>
            <p class="mb-0" style="white-space: pre-wrap;">{{ $ticket->message }}</p>
        </div>

        @if($ticket->attachments)
            <hr>
            <div>
                <h6 class="fw-semibold mb-2"><i class="fas fa-paperclip me-2"></i>Attachments</h6>
                <ul>
                    @foreach(json_decode($ticket->attachments) as $file)
                        <li><a href="{{ asset('storage/tickets/'.$file) }}" target="_blank">{{ $file }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>

<!-- Replies Section -->
@include('tickets.replies')

<!-- Reply Form -->
@if($ticket->status !== 'closed')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-reply me-2"></i>Add a Reply</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('tickets.reply', $ticket->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="message" class="form-label fw-semibold">Your Message</label>
                <textarea name="message" 
                          id="message" 
                          rows="5" 
                          class="form-control @error('message') is-invalid @enderror" 
                          placeholder="Type your reply here..."
                          required></textarea>
                @error('message')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane me-2"></i>Send Reply
            </button>
        </form>
    </div>
</div>
@else
<div class="alert alert-info">
    <i class="fas fa-info-circle me-2"></i>This ticket is closed. No further replies can be added.
</div>
@endif
@endsection
