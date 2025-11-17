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

                    <div class="mb-4">
                        <label class="form-label fw-semibold"><i class="fas fa-robot me-2"></i>{{__('AI Assistant')}}</label>
                        <div class="input-group mb-2">
                            <input type="text" id="ai_text" class="form-control" placeholder="{{__('Enter a short prompt or paste your description')}}">
                            <button type="button" class="btn btn-outline-primary" id="btn-ai-prompt">{{__('Generate From Prompt')}}</button>
                            <button type="button" class="btn btn-outline-secondary" id="btn-ai-refine">{{__('Refine Description')}}</button>
                        </div>
                        <small class="text-muted">{{__('Use AI to create or refine the ticket Title and Description')}}</small>
                    </div>

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
                        <label for="category_id" class="form-label fw-semibold">
                            <i class="fas fa-folder-open me-2"></i>{{__('Category')}}
                        </label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">{{__('Select Category')}}</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- AI Suggestions -->
                    <div class="mb-4" id="ai-suggestions" style="display:none;">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-robot me-2"></i>{{__('AI Suggested Questions')}}
                        </label>
                        <div class="list-group" id="suggestions-list"></div>
                        <small class="text-muted">{{__('Click a suggestion to insert into the message')}}</small>
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
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category_id');
    const suggestionsContainer = document.getElementById('ai-suggestions');
    const suggestionsList = document.getElementById('suggestions-list');
    const messageInput = document.getElementById('message');

    async function fetchSuggestions(categoryId) {
        const resp = await fetch('{{ route('ai.questions') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ category_id: categoryId })
        });
        const data = await resp.json();
        return data.suggestions || [];
    }

    function renderSuggestions(items) {
        suggestionsList.innerHTML = '';
        items.forEach(text => {
            const a = document.createElement('a');
            a.href = '#';
            a.className = 'list-group-item list-group-item-action';
            a.textContent = text;
            a.onclick = (e) => {
                e.preventDefault();
                const current = messageInput.value || '';
                messageInput.value = current ? (current + '\n\n' + text) : text;
                messageInput.focus();
            };
            suggestionsList.appendChild(a);
        });
        suggestionsContainer.style.display = items.length ? 'block' : 'none';
    }

    categorySelect.addEventListener('change', async function() {
        const id = this.value;
        if (!id) {
            renderSuggestions([]);
            return;
        }
        try {
            const suggestions = await fetchSuggestions(id);
            renderSuggestions(suggestions);
        } catch (e) {
            renderSuggestions([]);
        }
    });

    async function generateTicket(mode, text) {
        const resp = await fetch('{{ route('ai.ticket.generate') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ mode, text })
        });
        return await resp.json();
    }

    document.getElementById('btn-ai-prompt').addEventListener('click', async function() {
        const t = document.getElementById('ai_text').value.trim();
        if (!t) return;
        try {
            this.disabled = true;
            const refineBtn = document.getElementById('btn-ai-refine');
            if (refineBtn) refineBtn.disabled = true;
            const loader = document.getElementById('ai-loading');
            if (loader) loader.classList.remove('d-none');
            const data = await generateTicket('prompt', t);
            document.getElementById('subject').value = data.title || '';
            document.getElementById('message').value = data.description || '';
            flashSelect('subject');
            setTimeout(() => flashSelect('message'), 600);
        } catch (e) {
        } finally {
            this.disabled = false;
            const refineBtn = document.getElementById('btn-ai-refine');
            if (refineBtn) refineBtn.disabled = false;
            const loader = document.getElementById('ai-loading');
            if (loader) loader.classList.add('d-none');
        }
    });

    document.getElementById('btn-ai-refine').addEventListener('click', async function() {
        const t = document.getElementById('ai_text').value.trim() || document.getElementById('message').value.trim();
        if (!t) return;
        try {
            this.disabled = true;
            const promptBtn = document.getElementById('btn-ai-prompt');
            if (promptBtn) promptBtn.disabled = true;
            const loader = document.getElementById('ai-loading');
            if (loader) loader.classList.remove('d-none');
            const data = await generateTicket('refine', t);
            document.getElementById('subject').value = data.title || '';
            document.getElementById('message').value = data.description || '';
            flashSelect('subject');
            setTimeout(() => flashSelect('message'), 600);
        } catch (e) {
        } finally {
            this.disabled = false;
            const promptBtn = document.getElementById('btn-ai-prompt');
            if (promptBtn) promptBtn.disabled = false;
            const loader = document.getElementById('ai-loading');
            if (loader) loader.classList.add('d-none');
        }
    });

    function flashSelect(id) {
        const el = document.getElementById(id);
        if (!el) return;
        try {
            el.focus();
            if (typeof el.select === 'function') el.select();
            el.classList.add('flash-fill');
            setTimeout(() => el.classList.remove('flash-fill'), 800);
        } catch (e) {}
    }
});
</script>
@endpush
@push('styles')
<style>
    .ai-card { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.04); }
    .ai-icon { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; }
    .example-card { background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 12px; }
    .example-icon { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #22c55e 0%, #06b6d4 100%); color: #fff; }
    .example-body .border { border-color: #e5e7eb !important; }
    .example-body { font-size: 0.95rem; }
    .example-body strong { font-weight: 600; }
    .flash-fill { box-shadow: 0 0 0 3px rgba(102,126,234,0.25); transition: box-shadow .2s ease; }
</style>
@endpush
@endsection