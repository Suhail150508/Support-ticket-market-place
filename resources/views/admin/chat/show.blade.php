@extends('layouts.admin')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('page-title', __('Chat with') . ' ' . $user->name)

@section('content')
<div class="page-header mb-4">
    <div>
        <h1 class="mb-2"><i class="fas fa-comments me-2"></i>{{__('Chat with')}} {{ $user->name }}</h1>
        <p class="mb-0 opacity-75">{{ $user->email }}</p>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card chat-container">
            <div class="card-body p-0">
                <div class="chat-messages" id="chatMessages" style="height: 500px; overflow-y: auto; padding: 20px; background: #f8f9fa;">
                    @foreach($messages as $message)
                    <div class="message mb-3 {{ $message->sender_type === 'admin' ? 'text-end' : 'text-start' }}" data-message-id="{{ $message->id }}">
                        <div class="d-inline-block p-3 rounded {{ $message->sender_type === 'admin' ? 'bg-primary text-white' : 'bg-white border' }}" style="max-width: 70%;">
                            @if($message->attachments)
                                @php
                                    $attachments = is_string($message->attachments) ? json_decode($message->attachments, true) : $message->attachments;
                                @endphp
                                @if(is_array($attachments) && count($attachments) > 0)
                                    <div class="message-images mb-2">
                                        @foreach($attachments as $attachment)
                                            @if($attachment)
                                            @php
                                                $imageUrl = Storage::url('chat/' . $attachment);
                                            @endphp
                                            <a href="{{ $imageUrl }}" target="_blank" class="d-inline-block me-2 mb-2">
                                                <img src="{{ $imageUrl }}" alt="{{__('Attachment')}}" class="img-thumbnail" style="max-width: 150px; max-height: 150px; object-fit: cover; cursor: pointer; border: 1px solid #ddd; display: block;" onerror="console.error('{{__('Image not found:')}} {{ $imageUrl }}'); this.style.display='none';">
                                            </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                            @if($message->message)
                            <div class="message-text">{{ $message->message }}</div>
                            @endif
                            <small class="d-block mt-2 {{ $message->sender_type === 'admin' ? 'text-white-50' : 'text-muted' }}">
                                {{ $message->created_at->format('M d, Y H:i') }}
                            </small>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer bg-white border-top">
                    <form id="chatForm" class="d-flex gap-2 align-items-end">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="flex-grow-1 position-relative">
                            <input type="text" class="form-control" id="messageInput" placeholder="{{__('Type your message...')}}" autocomplete="off">
                            <input type="file" id="imageInput" accept="image/*" class="d-none" multiple>
                        </div>
                        <button type="button" class="btn btn-outline-secondary" id="imageBtn" title="{{__('Upload Image')}}">
                            <i class="fas fa-image"></i>
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>{{__('Send')}}
                        </button>
                    </form>
                    <div id="imagePreview" class="mt-2 d-none"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chatMessages');
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const imageInput = document.getElementById('imageInput');
    const imageBtn = document.getElementById('imageBtn');
    const imagePreview = document.getElementById('imagePreview');
    let selectedImages = [];
    let lastMessageId = {{ $messages->last()?->id ?? 0 }};
    let isTyping = false;

    chatMessages.scrollTop = chatMessages.scrollHeight;

    // Image upload button
    imageBtn.addEventListener('click', () => imageInput.click());

    // Handle image selection
    imageInput.addEventListener('change', function(e) {
        selectedImages = Array.from(e.target.files);
        displayImagePreview();
    });

    function displayImagePreview() {
        imagePreview.innerHTML = '';
        if (selectedImages.length > 0) {
            imagePreview.classList.remove('d-none');
            selectedImages.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'd-inline-block me-2 mb-2 position-relative';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" onclick="removeImage(${index})" style="padding: 2px 6px;">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    imagePreview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        } else {
            imagePreview.classList.add('d-none');
        }
    }

    window.removeImage = function(index) {
        selectedImages.splice(index, 1);
        displayImagePreview();
    };

    // Prevent form submission on Enter if typing
    messageInput.addEventListener('input', function() {
        isTyping = true;
        clearTimeout(window.typingTimeout);
        window.typingTimeout = setTimeout(() => {
            isTyping = false;
        }, 1000);
    });

    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message && selectedImages.length === 0) return;

        const formData = new FormData();
        formData.append('message', message || '');
        formData.append('user_id', {{ $user->id }});
        selectedImages.forEach((file, index) => {
            formData.append(`images[${index}]`, file);
        });

        // Disable form during submission
        const submitBtn = chatForm.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>{{__("Sending...")}}';

        fetch('{{ route("admin.chat.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageInput.value = '';
                selectedImages = [];
                imageInput.value = '';
                imagePreview.classList.add('d-none');
                isTyping = false;
                messageInput.blur();
                // Reload messages after a short delay
                setTimeout(() => loadNewMessages(true), 300);
            } else {
                alert('{{__("Failed to send message")}}');
            }
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>{{__("Send")}}';
        })
        .catch(error => {
            console.error('{{__("Error:")}}', error);
            alert('{{__("Failed to send message")}}');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>{{__("Send")}}';
        });
    });

    // Load new messages without page reload
    function loadNewMessages(force = false) {
        if (!force && isTyping) return;
        
        fetch('{{ route("chat.messages") }}?user_id={{ $user->id }}&last_id=' + lastMessageId)
            .then(response => response.json())
            .then(messages => {
                if (messages.length > 0) {
                    const existingIds = Array.from(chatMessages.querySelectorAll('.message')).map(el => parseInt(el.getAttribute('data-message-id')));
                    messages.forEach(msg => {
                        if (msg.id > lastMessageId && !existingIds.includes(msg.id)) {
                            addMessageToChat(msg);
                            lastMessageId = msg.id;
                        }
                    });
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            })
            .catch(error => console.error('{{__("Error loading messages:")}}', error));
    }

    function addMessageToChat(msg) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message mb-3 ${msg.sender_type === 'admin' ? 'text-end' : 'text-start'}`;
        messageDiv.setAttribute('data-message-id', msg.id);
        
        let attachmentsHtml = '';
        if (msg.attachments && Array.isArray(msg.attachments) && msg.attachments.length > 0) {
            attachmentsHtml = '<div class="message-images mb-2">';
            msg.attachments.forEach(att => {
                if (att) {
                    // Use asset helper for proper URL generation
                    const imageUrl = `{{ url('/') }}/storage/chat/${encodeURIComponent(att)}`;
                    attachmentsHtml += `<a href="${imageUrl}" target="_blank" class="d-inline-block me-2 mb-2">
                        <img src="${imageUrl}" alt="{{__('Attachment')}}" class="img-thumbnail" style="max-width: 150px; max-height: 150px; object-fit: cover; cursor: pointer; border: 1px solid #ddd;" onerror="console.error('{{__('Image failed to load:')}}', '${imageUrl}'); this.parentElement.style.display='none';">
                    </a>`;
                }
            });
            attachmentsHtml += '</div>';
        }
        
        messageDiv.innerHTML = `
            <div class="d-inline-block p-3 rounded ${msg.sender_type === 'admin' ? 'bg-primary text-white' : 'bg-white border'}" style="max-width: 70%;">
                ${attachmentsHtml}
                ${msg.message ? `<div class="message-text">${msg.message}</div>` : ''}
                <small class="d-block mt-2 ${msg.sender_type === 'admin' ? 'text-white-50' : 'text-muted'}">
                    ${new Date(msg.created_at).toLocaleString()}
                </small>
            </div>
        `;
        chatMessages.appendChild(messageDiv);
    }

    // Poll for new messages every 3 seconds
    setInterval(function() {
        if (!isTyping) {
            loadNewMessages();
        }
    }, 3000);
});
</script>
@endpush

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@endsection