@extends('layouts.app')

@section('title', __('Create New Ticket'))

@section('content')
<div class="page-header">
    <div>
        <h1 class="mb-2"><i class="fas fa-plus-circle me-2"></i>{{__('Create New Ticket')}}</h1>
        <p class="mb-0 opacity-75">{{__('Submit a new support ticket to get help')}}</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-ticket-alt me-2"></i>{{__('Ticket Information')}}</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Subject -->
                    <div class="mb-4">
                        <label for="subject" class="form-label fw-semibold">
                            <i class="fas fa-heading me-2"></i>{{__('Subject')}} <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg @error('subject') is-invalid @enderror" 
                               id="subject" 
                               name="subject" 
                               value="{{ old('subject') }}" 
                               placeholder="{{__('Enter ticket subject')}}"
                               required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">{{__('A brief description of your issue')}}</small>
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category" class="form-label fw-semibold">
                            <i class="fas fa-folder-open me-2"></i>{{__('Category')}}
                        </label>
                        <select name="category" id="category" class="form-select">
                            <option value="">{{__('Select Category')}}</option>
                            <option value="billing">{{__('Billing')}}</option>
                            <option value="technical">{{__('Technical')}}</option>
                            <option value="general">{{__('General')}}</option>
                        </select>
                    </div>

                    <!-- Priority -->
                    <div class="mb-4">
                        <label for="priority" class="form-label fw-semibold">
                            <i class="fas fa-exclamation-circle me-2"></i>{{__('Priority')}}
                        </label>
                        <select name="priority" id="priority" class="form-select">
                            <option value="low">{{__('Low')}}</option>
                            <option value="medium" selected>{{__('Medium')}}</option>
                            <option value="high">{{__('High')}}</option>
                            <option value="urgent">{{__('Urgent')}}</option>
                        </select>
                    </div>

                    <!-- Message -->
                    <div class="mb-4">
                        <label for="message" class="form-label fw-semibold">
                            <i class="fas fa-comment-alt me-2"></i>{{__('Message')}} <span class="text-danger">*</span>
                        </label>
                        <textarea name="message" 
                                  id="message" 
                                  rows="8" 
                                  class="form-control @error('message') is-invalid @enderror" 
                                  placeholder="{{__('Describe your issue in detail...')}}"
                                  required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">{{__('Provide as much detail as possible to help us assist you better')}}</small>
                    </div>

                    <!-- Attachment -->
                    <div class="mb-4">
                        <label for="attachments" class="form-label fw-semibold">
                            <i class="fas fa-paperclip me-2"></i>{{__('Attachments')}}
                        </label>
                        <input type="file" 
                            id="attachments"
                            class="form-control" 
                            name="attachments[]" 
                            multiple
                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                        <small class="text-muted">{{__('You can attach images, PDFs, or documents (max 5MB each)')}}</small>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>{{__('Cancel')}}
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>{{__('Submit Ticket')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Card -->
        <div class="card mt-4">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">
                    <i class="fas fa-lightbulb text-warning me-2"></i>{{__('Tips for creating a ticket')}}
                </h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{__('Be specific about your issue')}}</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{__('Include any error messages you\'ve encountered')}}</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{__('Mention steps you\'ve already tried')}}</li>
                    <li class="mb-0"><i class="fas fa-check-circle text-success me-2"></i>{{__('Provide relevant screenshots if applicable')}}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection