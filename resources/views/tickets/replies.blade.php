@if($ticket->replies->count() > 0)
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-comments me-2"></i>Conversation ({{ $ticket->replies->count() }} replies)</h5>
    </div>
    <div class="card-body p-0">
        <div class="p-4">
            @foreach($ticket->replies as $reply)
            <div class="mb-4 pb-4 {{ !$loop->last ? 'border-bottom' : '' }}">
                <div class="d-flex align-items-start">
                    <div class="flex-shrink-0">
                        <div class="bg-{{ $reply->user->role == 'admin' ? 'primary' : 'secondary' }} bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-user-{{ $reply->user->role == 'admin' ? 'shield' : 'circle' }} fa-2x text-{{ $reply->user->role == 'admin' ? 'primary' : 'secondary' }}"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1">
                                    {{ $reply->user->name }}
                                    @if($reply->user->role == 'admin')
                                        <span class="badge bg-primary ms-2">
                                            <i class="fas fa-user-shield me-1"></i>Admin
                                        </span>
                                    @else
                                        <span class="badge bg-secondary ms-2">User</span>
                                    @endif
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>{{ $reply->created_at->diffForHumans() }}
                                    ({{ $reply->created_at->format('M d, Y H:i') }})
                                </small>
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="bg-light rounded p-3 mb-2">
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $reply->message }}</p>
                        </div>

                        <!-- Attachment -->
                        @if($reply->attachment)
                        <div>
                            <strong>Attachments:</strong>
                            <ul class="list-unstyled mb-0">
                                @foreach(json_decode($reply->attachment) as $file)
                                    <li>
                                        <a href="{{ asset('storage/' . $file) }}" target="_blank">
                                            <i class="fas fa-paperclip me-1"></i>{{ basename($file) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@else
<div class="card mb-4">
    <div class="card-body text-center py-5">
        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
        <p class="text-muted mb-0">No replies yet. Be the first to respond!</p>
    </div>
</div>
@endif
