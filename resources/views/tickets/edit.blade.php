@extends('layouts.app')

@section('title', 'Edit Support Ticket')

@section('content')
<div class="page-header">
    <div>
        <h1 class="mb-2"><i class="fas fa-edit me-2"></i>Edit Support Ticket</h1>
        <p class="mb-0 text-muted">Update your ticket information and attachments.</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-ticket-alt me-2"></i>Ticket Details</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Subject -->
                    <div class="mb-4">
                        <label for="subject" class="form-label fw-semibold">
                            <i class="fas fa-heading me-2"></i>Subject <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="subject"
                               name="subject"
                               value="{{ old('subject', $ticket->subject) }}"
                               class="form-control form-control-lg @error('subject') is-invalid @enderror"
                               placeholder="Enter a brief title for your issue"
                               required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category_id" class="form-label fw-semibold">
                            <i class="fas fa-folder-open me-2"></i>Category <span class="text-danger"></span>
                        </label>
                        <select name="category_id" id="category_id" class="form-select" >
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ (old('category_id', $ticket->category_id) == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div class="mb-4">
                        <label for="department_id" class="form-label fw-semibold">
                            <i class="fas fa-building me-2"></i>Department <span class="text-danger"></span>
                        </label>
                        <select name="department_id" id="department_id" class="form-select" >
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" 
                                    {{ (old('department_id', $ticket->department_id) == $department->id) ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Priority -->
                    <div class="mb-4">
                        <label for="priority" class="form-label fw-semibold">
                            <i class="fas fa-exclamation-circle me-2"></i>Priority
                        </label>
                        <select name="priority" id="priority" class="form-select">
                            @php $priorityOld = old('priority', $ticket->priority) @endphp
                            <option value="low" {{ $priorityOld == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ $priorityOld == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $priorityOld == 'high' ? 'selected' : '' }}>High</option>
                            <option value="urgent" {{ $priorityOld == 'urgent' ? 'selected' : '' }}>Urgent</option>
                        </select>
                    </div>

                    <!-- Message -->
                    <div class="mb-4">
                        <label for="message" class="form-label fw-semibold">
                            <i class="fas fa-comment-alt me-2"></i>Message <span class="text-danger">*</span>
                        </label>
                        <textarea name="message"
                                  id="message"
                                  rows="6"
                                  class="form-control @error('message') is-invalid @enderror"
                                  placeholder="Describe your issue in detail..."
                                  required>{{ old('message', $ticket->message) }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Existing Attachments -->
                    @if($ticket->attachments && count($ticket->attachments) > 0)
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fas fa-paperclip me-2"></i>Existing Attachments</label>
                            <ul class="list-group">
                                @foreach($ticket->attachments as $file)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="{{ asset('storage/tickets/' . $file) }}" target="_blank">{{ $file }}</a>
                                        <!-- Optional: Add a remove button (handle with JS or new route) -->
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- New Attachments -->
                    <div class="mb-4">
                        <label for="attachments" class="form-label fw-semibold">
                            <i class="fas fa-paperclip me-2"></i>Add Attachments
                        </label>
                        <input type="file"
                               id="attachments"
                               name="attachments[]"
                               class="form-control"
                               multiple
                               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                        <small class="text-muted">Attach new files if needed (Max 5MB each)</small>
                    </div>

                    <!-- Submit -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Update Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
