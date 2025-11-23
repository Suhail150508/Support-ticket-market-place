@extends('layouts.app')

@section('title', __('Edit Support Ticket'))

@section('content')
<div class="page-header">
    <div>
        <h1 class="mb-2"><i class="fas fa-edit me-2"></i>{{__('Edit Support Ticket')}}</h1>
        <p class="mb-0 text-muted">{{__('Update your ticket information and attachments.')}}</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-ticket-alt me-2"></i>{{__('Ticket Details')}}</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Subject -->
                    <div class="mb-4">
                        <label for="subject" class="form-label fw-semibold">
                            <i class="fas fa-heading me-2"></i>{{__('Subject')}} <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="subject"
                               name="subject"
                               value="{{ old('subject', $ticket->subject) }}"
                               class="form-control form-control-lg @error('subject') is-invalid @enderror"
                               placeholder="{{__('Enter a brief title for your issue')}}"
                               required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category_id" class="form-label fw-semibold">
                            <i class="fas fa-folder-open me-2"></i>{{__('Category')}} <span class="text-danger"></span>
                        </label>
                        <select name="category_id" id="category_id" class="form-select" >
                            <option value="">{{__('Select Category')}}</option>
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
                            <i class="fas fa-building me-2"></i>{{__('Department')}} <span class="text-danger"></span>
                        </label>
                        <select name="department_id" id="department_id" class="form-select" >
                            <option value="">{{__('Select Department')}}</option>
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
                            <i class="fas fa-exclamation-circle me-2"></i>{{__('Priority')}}
                        </label>
                        <select name="priority" id="priority" class="form-select">
                            @php $priorityOld = old('priority', $ticket->priority) @endphp
                            <option value="low" {{ $priorityOld == 'low' ? 'selected' : '' }}>{{__('Low')}}</option>
                            <option value="medium" {{ $priorityOld == 'medium' ? 'selected' : '' }}>{{__('Medium')}}</option>
                            <option value="high" {{ $priorityOld == 'high' ? 'selected' : '' }}>{{__('High')}}</option>
                            <option value="urgent" {{ $priorityOld == 'urgent' ? 'selected' : '' }}>{{__('Urgent')}}</option>
                        </select>
                    </div>

                    <!-- Message -->
                    <div class="mb-4">
                        <label for="message" class="form-label fw-semibold">
                            <i class="fas fa-comment-alt me-2"></i>{{__('Message')}} <span class="text-danger">*</span>
                        </label>
                        <textarea name="message"
                                  id="message"
                                  rows="6"
                                  class="form-control @error('message') is-invalid @enderror"
                                  placeholder="{{__('Describe your issue in detail...')}}"
                                  required>{{ old('message', $ticket->message) }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Existing Attachments -->
                    @if($ticket->attachments && count($ticket->attachments) > 0)
                        <hr>
                        <div class="mb-4">
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
                                                        <img src="{{ getImageOrPlaceholder('tickets/' . $file, '150px', 'img-fluid rounded') }}" 
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
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- New Attachments -->
                    <div class="mb-4">
                        <label for="attachments" class="form-label fw-semibold">
                            <i class="fas fa-paperclip me-2"></i>{{__('Add Attachments')}}
                        </label>
                        <input type="file"
                               id="attachments"
                               name="attachments[]"
                               class="form-control"
                               multiple
                               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                        <small class="text-muted">{{__('Attach new files if needed (Max 5MB each)')}}</small>
                    </div>

                    <!-- Submit -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>{{__('Cancel')}}
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>{{__('Update Ticket')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection