@extends('layouts.admin')

@section('page-title', __('Create New Ticket'))

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>{{ __('Create New Ticket')}}</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.tickets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- User -->
                    <div class="mb-4">
                        <label for="user_id" class="form-label fw-semibold">
                            <i class="fas fa-user me-2"></i>{{ __('User')}} <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-lg @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                            <option value="">{{ __('Select User')}}</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
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
                            <i class="fas fa-building me-2"></i>{{ __('Department')}}
                        </label>
                        <select class="form-select form-select-lg @error('department_id') is-invalid @enderror" id="department_id" name="department_id">
                            <option value="">{{ __('Select Department')}}</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
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
                            <i class="fas fa-tags me-2"></i>{{ __('Category')}}
                        </label>
                        <select class="form-select form-select-lg @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                            <option value="">{{ __('Select Category')}}</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
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
                            <i class="fas fa-heading me-2"></i>{{ __('Subject')}} <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg @error('subject') is-invalid @enderror" 
                               id="subject" 
                               name="subject" 
                               value="{{ old('subject') }}" 
                               placeholder="{{ __('Enter ticket subject')}}"
                               required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div class="mb-4">
                        <label for="message" class="form-label fw-semibold">
                            <i class="fas fa-comment-alt me-2"></i>{{ __('Message')}} <span class="text-danger">*</span>
                        </label>
                        <textarea name="message" 
                                  id="message" 
                                  rows="8" 
                                  class="form-control @error('message') is-invalid @enderror" 
                                  placeholder="{{ __('Enter ticket message...')}}"
                                  required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Priority -->
                    <div class="mb-4">
                        <label for="priority" class="form-label fw-semibold">
                            <i class="fas fa-bolt me-2"></i>{{ __('Priority')}}
                        </label>
                        <select class="form-select form-select-lg @error('priority') is-invalid @enderror" id="priority" name="priority">
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>{{ __('Low')}}</option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>{{ __('Medium')}}</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>{{ __('High')}}</option>
                            <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>{{ __('Urgent')}}</option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="form-label fw-semibold">
                            <i class="fas fa-info-circle me-2"></i>{{ __('Status')}}
                        </label>
                        <select class="form-select form-select-lg @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>{{ __('Open')}}</option>
                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress')}}</option>
                            <option value="resolved" {{ old('status') == 'resolved' ? 'selected' : '' }}>{{ __('Resolved')}}</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending')}}</option>
                            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>{{ __('Closed')}}</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Attachments -->
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


                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>{{ __('Cancel')}}
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>{{ __('Create Ticket')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection