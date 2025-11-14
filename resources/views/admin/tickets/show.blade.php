@extends('layouts.admin')

@section('page-title', __('Ticket #') . $ticket->id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.tickets.index') }}">{{ __('Tickets')}}</a></li>
                <li class="breadcrumb-item active">{{ __('Ticket #')}}{{ $ticket->id }}</li>
            </ol>
        </nav>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>{{ __('Edit')}}
        </a>
        <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('Are you sure you want to delete this ticket?')}}')">
                <i class="fas fa-trash me-2"></i>{{ __('Delete')}}
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
                <small class="text-muted d-block mb-1">{{ __('Department')}}</small>
                <strong>{{ $ticket->department?->name ?? '-' }}</strong>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block mb-1">{{ __('Category')}}</small>
                <strong>{{ $ticket->category?->name ?? '-' }}</strong>
            </div>
            <div class="col-md-6 mt-3">
                <small class="text-muted d-block mb-1">{{ __('Priority')}}</small>
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
                <small class="text-muted d-block mb-1">{{ __('Assigned To')}}</small>
                <strong>{{ $ticket->assignedTo?->name ?? '-' }}</strong>
            </div>
        </div>

        <hr>

        <div class="mb-3">
            <h6 class="fw-semibold mb-2"><i class="fas fa-file-alt me-2"></i>{{ __('Description')}}</h6>
            <p class="mb-0" style="white-space: pre-wrap;">{{ $ticket->message }}</p>
        </div>

         @if($ticket->attachments && count($ticket->attachments) > 0)
            <hr>
            <div>
                <h6 class="fw-semibold mb-3"><i class="fas fa-paperclip me-2"></i>{{ __('Attachments')}}</h6>
                
                <div class="row g-3">
                    @foreach($ticket->attachments as $file)
                        @php
                            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            
                            // Try different path variations
                            $path1 = asset('storage/tickets/' . $file);
                            $path2 = asset('tickets/' . $file);
                            $path3 = Storage::url('tickets/' . $file);
                        @endphp
                        
                        <div class="col-md-4 col-sm-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    
                                    @if($isImage)
                                        {{-- Try to load image --}}
                                        <div class="text-center mb-2">
                                            <img src="{{ Storage::url('tickets/' . $file) }}" 
                                                alt="{{ $file }}" 
                                                class="img-fluid rounded"
                                                style="max-height: 150px; object-fit: cover;"
                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                            <div style="display:none;" class="text-danger">
                                                <i class="fas fa-exclamation-triangle"></i> Image failed to load
                                            </div>
                                        </div>
                                    @else
                                        {{-- File Icon --}}
                                        <div class="text-center mb-2">
                                            @if($extension == 'pdf')
                                                <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                            @elseif(in_array($extension, ['doc', 'docx']))
                                                <i class="fas fa-file-word fa-4x text-primary"></i>
                                            @else
                                                <i class="fas fa-file fa-4x text-secondary"></i>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    {{-- Download Link --}}
                                    <div class="text-center">
                                        <a href="{{ Storage::url('tickets/' . $file) }}" 
                                        target="_blank" 
                                        class="btn btn-sm btn-outline-primary"
                                        download>
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>
                                    </div>
                                    
                                    <div class="text-truncate mt-2 text-center" title="{{ $file }}">
                                        <small>{{ $file }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
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
        <h5 class="mb-0"><i class="fas fa-reply me-2"></i>{{ __('Add a Reply')}}</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('tickets.reply', $ticket->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="message" class="form-label fw-semibold">{{ __('Your Message')}}</label>
                <textarea name="message" 
                          id="message" 
                          rows="5" 
                          class="form-control @error('message') is-invalid @enderror" 
                          placeholder="{{ __('Type your reply here...')}}"
                          required></textarea>
                @error('message')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane me-2"></i>{{ __('Send Reply')}}
            </button>
        </form>
    </div>
</div>
@else
<div class="alert alert-info">
    <i class="fas fa-info-circle me-2"></i>{{ __('This ticket is closed. No further replies can be added.')}}
</div>
@endif
@endsection