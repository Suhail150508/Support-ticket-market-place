@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="page-header">
    <div>
        <h1 class="mb-2"><i class="fas fa-user me-2"></i>Profile Settings</h1>
        <p class="mb-0 opacity-75">Manage your account information and preferences</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Update Profile Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Profile Information</h5>
            </div>
            <div class="card-body p-4">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-lock me-2"></i>Update Password</h5>
            </div>
            <div class="card-body p-4">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Delete Account</h5>
            </div>
            <div class="card-body p-4">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center p-4">
                <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                    <i class="fas fa-user-circle fa-4x text-primary"></i>
                </div>
                <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                <p class="text-muted mb-2">{{ auth()->user()->email }}</p>
                <span class="badge 
                    @if(auth()->user()->role == 'admin') bg-primary
                    @else bg-secondary @endif">
                    <i class="fas fa-user-{{ auth()->user()->role == 'admin' ? 'shield' : 'circle' }} me-1"></i>
                    {{ ucfirst(auth()->user()->role) }}
                </span>
                <hr>
                <div class="text-start">
                    <small class="text-muted d-block mb-2">
                        <i class="fas fa-calendar me-2"></i>
                        Member since {{ auth()->user()->created_at->format('M Y') }}
                    </small>
                    <small class="text-muted d-block">
                        <i class="fas fa-ticket-alt me-2"></i>
                        {{ auth()->user()->tickets()->count() }} tickets created
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
