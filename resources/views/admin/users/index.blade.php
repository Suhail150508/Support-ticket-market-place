@extends('layouts.admin')

@section('page-title', 'User Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0"><i class="fas fa-users me-2"></i>Users</h2>
        <p class="text-muted mb-0">Manage system users</p>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Users</h5>
        <span class="badge bg-primary">{{ $users->total() }} Total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tickets</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td><strong>#{{ $user->id }}</strong></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div class="fw-semibold">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge 
                                @if($user->role == 'admin') bg-primary
                                @else bg-secondary @endif">
                                <i class="fas fa-user-{{ $user->role == 'admin' ? 'shield' : 'circle' }} me-1"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $user->tickets()->count() }}</span>
                        </td>
                        <td><small>{{ $user->created_at->format('M d, Y') }}</small></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No users found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer">
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
    @endif
</div>
@endsection

