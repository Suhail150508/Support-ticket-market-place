@extends('layouts.admin')

@section('page-title', 'Edit Ticket #' . $ticket->id)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Ticket #{{ $ticket->id }}</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- User -->
                    <div class="mb-4">
                        <label for="user_id" class="form-label fw-semibold">
                            <i class="fas fa-user me-2"></i>User <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-lg @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ (old('user_id', $ticket->user_id) == $user->id) ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div class="mb-4">
                        <label for="department_id" class="form-label fw-semibold">
                            <i class="fas fa-building me-2"></i>Department
                        </label>
                        <select class="form-select form-select-lg @error('department_id') is-invalid @enderror" id="department_id" name="department_id">
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ (old('department_id', $ticket->department_id) == $dept->id) ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category_id" class="form-label fw-semibold">
                            <i class="fas fa-tags me-2"></i>Category
                        </label>
                        <select class="form-select form-select-lg @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ (old('category_id', $ticket->category_id) == $cat->id) ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div class="mb-4">
                        <label for="subject" class="form-label fw-semibold">
                            <i class="fas fa-heading me-2"></i>Subject <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg @error('subject') is-invalid @enderror" 
                               id="subject" 
                               name="subject" 
                               value="{{ old('subject', $ticket->subject) }}" 
                               placeholder="Enter ticket subject"
                               required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div class="mb-4">
                        <label for="message" class="form-label fw-semibold">
                            <i class="fas fa-comment-alt me-2"></i>Message <span class="text-danger">*</span>
                        </label>
                        <textarea name="message" 
                                  id="message" 
                                  rows="8" 
                                  class="form-control @error('message') is-invalid @enderror" 
                                  placeholder="Enter ticket message..."
                                  required>{{ old('message', $ticket->message) }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Priority -->
                    <div class="mb-4">
                        <label for="priority" class="form-label fw-semibold">
                            <i class="fas fa-bolt me-2"></i>Priority
                        </label>
                        <select class="form-select form-select-lg @error('priority') is-invalid @enderror" id="priority" name="priority">
                            <option value="low" {{ (old('priority', $ticket->priority) == 'low') ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ (old('priority', $ticket->priority) == 'medium') ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ (old('priority', $ticket->priority) == 'high') ? 'selected' : '' }}>High</option>
                            <option value="urgent" {{ (old('priority', $ticket->priority) == 'urgent') ? 'selected' : '' }}>Urgent</option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="form-label fw-semibold">
                            <i class="fas fa-info-circle me-2"></i>Status
                        </label>
                        <select class="form-select form-select-lg @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="open" {{ (old('status', $ticket->status) == 'open') ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ (old('status', $ticket->status) == 'in_progress') ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ (old('status', $ticket->status) == 'resolved') ? 'selected' : '' }}>Resolved</option>
                            <option value="pending" {{ (old('status', $ticket->status) == 'pending') ? 'selected' : '' }}>Pending</option>
                            <option value="closed" {{ (old('status', $ticket->status) == 'closed') ? 'selected' : '' }}>Closed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Attachments -->
                    <div class="mb-4">
                        <label for="attachments" class="form-label fw-semibold">
                            <i class="fas fa-paperclip me-2"></i>Attachments
                        </label>
                        <input type="file" name="attachments[]" class="form-control" multiple>
                        <small class="text-muted">You can upload multiple files (jpg, png, pdf, etc.)</small>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Update Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
