@extends('layouts.admin')

@section('page-title', __('Live Chat Management'))

@section('content')
<div class="page-header mb-4">
    <div>
        <h1 class="mb-2"><i class="fas fa-comments me-2"></i>{{__('Live Chat Management')}}</h1>
        <p class="mb-0 opacity-75">{{__('Manage user chat conversations')}}</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-users me-2"></i>{{__('Users with Active Chats')}}</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>{{__('User')}}</th>
                        <th>{{__('Email')}}</th>
                        <th>{{__('Unread Messages')}}</th>
                        <th>{{__('Last Message')}}</th>
                        <th>{{__('Actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->unread_count > 0)
                                <span class="badge bg-danger">{{ $user->unread_count }} {{__('unread')}}</span>
                            @else
                                <span class="badge bg-secondary">0</span>
                            @endif
                        </td>
                        <td>
                            <small>{{ $user->chatMessages()->latest()->first()?->created_at->format('M d, Y H:i') ?? __('N/A') }}</small>
                        </td>
                        <td>
                            <a href="{{ route('admin.chat.show', $user->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-comments me-1"></i>{{__('Open Chat')}}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <p class="text-muted">{{__('No active chats found.')}}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection