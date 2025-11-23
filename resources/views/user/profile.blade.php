@extends('layouts.user')

@section('page-title', __('My Profile'))

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Profile Header Card -->
        <div class="card mb-4">
            <div class="card-body text-center profile-header-body">
                <div class="mb-4">
                    <div class="user-avatar-large mx-auto mb-3 position-relative">
                        <img src="{{ getImageOrPlaceholder($user->image, '30x30') }}" alt="Profile Image" class="user-profile-image" />
                    </div>
                    <h3 class="mb-1">{{ $user->name }}</h3>
                    <p class="text-muted mb-0">{{ $user->email }}</p>
                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }} mt-2">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Profile Information Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-edit me-2"></i>{{ __('Profile Information') }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="file" id="imageInput" name="image" accept="image/*" class="d-none" onchange="previewImage(this)">
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('Profile Image') }}</label>
                        <div class="image-upload-container">
                            <div id="imagePreviewContainer" class="d-none">
                                <img id="imagePreview" src="" alt="Preview" class="image-preview-thumb">
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('imageInput').click();">
                                    <i class="fas fa-upload me-2"></i>{{ __('Choose Image') }}
                                </button>
                                <small class="d-block text-muted mt-1">{{ __('Max size: 2MB. Formats: JPG, PNG, GIF, WEBP') }}</small>
                                @error('image')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Full Name') }}</label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}" 
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3">{{ __('Change Password') }}</h6>
                    <p class="text-muted small mb-3">{{ __('Leave blank if you don\'t want to change your password') }}</p>

                    <div class="mb-3">
                        <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                        <input type="password" 
                               class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" 
                               name="current_password">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('New Password') }}</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">{{ __('Minimum 4 characters') }}</small>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm New Password') }}</label>
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation">
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>{{ __('Cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>{{ __('Update Profile') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Account Statistics -->
        <div class="row g-4 mt-2">
            <div class="col-md-4">
                <div class="card">
                    <div class="stat-card-body">
                        <i class="fas fa-ticket-alt fa-2x text-primary mb-3"></i>
                        <h4 class="mb-1">{{ $user->tickets()->count() }}</h4>
                        <p class="text-muted mb-0 small">{{ __('Total Tickets') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="stat-card-body">
                        <i class="fas fa-credit-card fa-2x text-success mb-3"></i>
                        <h4 class="mb-1">{{ $user->subscriptions()->count() }}</h4>
                        <p class="text-muted mb-0 small">{{ __('Total Subscriptions') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="stat-card-body">
                        <i class="fas fa-calendar-alt fa-2x text-info mb-3"></i>
                        <h4 class="mb-1">{{ $user->created_at->format('M Y') }}</h4>
                        <p class="text-muted mb-0 small">{{ __('Member Since') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')

@endpush

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreviewContainer').classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection