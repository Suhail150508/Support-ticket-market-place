@extends('layouts.app')

@section('title', 'Ticket #' . $ticket->id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('tickets.index') }}">My Tickets</a></li>
                <li class="breadcrumb-item active">Ticket #{{ $ticket->id }}</li>
            </ol>
        </nav>
    </div>
    <div>
        <span class="badge 
            @if($ticket->status === 'open') bg-success
            @elseif($ticket->status === 'pending') bg-warning
            @elseif($ticket->status === 'closed') bg-secondary
            @else bg-primary @endif badge-lg">
            <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
            {{ ucfirst($ticket->status) }}
        </span>
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
    </div>
    <div class="card-body p-4">

        <!-- Description -->
        <div class="mb-3">
            <h6 class="fw-semibold mb-2"><i class="fas fa-file-alt me-2"></i>Description</h6>
            <p class="mb-0" style="white-space: pre-wrap;">{{ $ticket->message }}</p>
        </div>

        <!-- Category & Priority -->
        <div class="row mb-3">
            <div class="col-md-6">
                <small class="text-muted d-block mb-1">Category</small>
                <strong>{{ ucfirst($ticket->category ?? 'N/A') }}</strong>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block mb-1">Priority</small>
                <span class="badge bg-{{ $ticket->priority === 'urgent' ? 'danger' : ($ticket->priority === 'high' ? 'warning' : 'info') }}">
                    {{ ucfirst($ticket->priority) }}
                </span>
            </div>
        </div>

        <!-- Timestamps -->
        <div class="row">
            <div class="col-md-6">
                <small class="text-muted d-block mb-1">Ticket ID</small>
                <strong>#{{ $ticket->id }}</strong>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block mb-1">Status</small>
                <span class="badge 
                    @if($ticket->status === 'open') bg-success
                    @elseif($ticket->status === 'pending') bg-warning
                    @elseif($ticket->status === 'closed') bg-secondary
                    @else bg-primary @endif">
                    {{ ucfirst($ticket->status) }}
                </span>
            </div>
            <div class="col-md-6 mt-3">
                <small class="text-muted d-block mb-1">Created</small>
                <strong>{{ $ticket->created_at->format('M d, Y H:i') }}</strong>
            </div>
            <div class="col-md-6 mt-3">
                <small class="text-muted d-block mb-1">Last Updated</small>
                <strong>{{ $ticket->updated_at->format('M d, Y H:i') }}</strong>
            </div>
        </div>

        <!-- Attachments -->
        @if($ticket->attachment)
        <div class="mt-3">
            <h6 class="fw-semibold mb-2"><i class="fas fa-paperclip me-2"></i>Attachments</h6>
            <ul>
                @foreach(json_decode($ticket->attachment) as $file)
                    <li><a href="{{ asset('storage/' . $file) }}" target="_blank">{{ basename($file) }}</a></li>
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
        <form action="{{ route('tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data">
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
            <div class="mb-3">
                <label for="attachment" class="form-label fw-semibold">Attachments</label>
                <input type="file" class="form-control" name="attachment[]" multiple>
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
