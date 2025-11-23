@extends('layouts.admin')

@section('page-title', __('Edit Home Page Section'))

@section('content')
<div class="page-header mb-4">
    <div>
        <h1 class="mb-2"><i class="fas fa-edit me-2"></i>{{__('Edit Section:')}} {{ $section->section_name }}</h1>
        <p class="mb-0 opacity-75">{{__('Update the content for this home page section')}}</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-cog me-2"></i>{{__('Section Details')}}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.homepage.update', $section->id) }}" method="POST" id="homepageForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{__('Section Key')}}</label>
                    <input type="text" class="form-control" value="{{ $section->section_key }}" disabled>
                    <small class="text-muted">{{__('Section key cannot be changed')}}</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{__('Section Name')}} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="section_name" value="{{ $section->section_name }}" required>
                </div>
            </div>

           <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{__('Sort Order')}}</label>
                    <input type="number" class="form-control" name="sort_order" value="{{ $section->sort_order }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{__('Status')}}</label>
                    <div class="form-check form-switch mt-2">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ $section->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">{{__('Active')}}</label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">{{__('Content (JSON)')}} <span class="text-danger">*</span></label>
                <textarea class="form-control font-monospace" name="content" id="content" rows="15" required>{{ json_encode($section->content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</textarea>
                <small class="text-muted">{{__('Enter valid JSON format. Use the examples below as reference.')}}</small>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.homepage.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{__('Back')}}
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>{{__('Update Section')}}
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>{{__('Content Format Examples')}}</h5>
    </div>
    <div class="card-body">
        <div class="accordion" id="examplesAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#heroExample">
                        {{__('Hero Section Example')}}
                    </button>
                </h2>
                <div id="heroExample" class="accordion-collapse collapse show" data-bs-parent="#examplesAccordion">
                    <div class="accordion-body">
                        <pre class="bg-light p-3 rounded"><code>{
    "title": "{{__('Revolutionize Your Customer Support Experience')}}",
    "subtitle": "{{__('AI-powered ticket management system...')}}",
    "primary_button": {
        "text": "{{__('Start Free Trial')}}",
        "url": "/register"
    },
    "secondary_button": {
        "text": "{{__('Watch Demo')}}",
        "url": "#features"
    },
    "features": ["{{__('No credit card required')}}", "{{__('14-day free trial')}}", "{{__('Setup in 5 minutes')}}"]
}</code></pre>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#featuresExample">
                        {{__('Features Section Example')}}
                    </button>
                </h2>
                <div id="featuresExample" class="accordion-collapse collapse" data-bs-parent="#examplesAccordion">
                    <div class="accordion-body">
                        <pre class="bg-light p-3 rounded"><code>{
    "title": "{{__('Everything You Need for Superior Support')}}",
    "subtitle": "{{__('Powerful features that transform...')}}",
    "items": [
        {
            "icon": "fas fa-bolt",
            "title": "{{__('Lightning Fast')}}",
            "description": "{{__('Instant ticket creation...')}}"
        },
        {
            "icon": "fas fa-brain",
            "title": "{{__('Smart Automation')}}",
            "description": "{{__('AI-powered routing...')}}"
        }
    ]
}</code></pre>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#statsExample">
                        {{__('Stats Section Example')}}
                    </button>
                </h2>
                <div id="statsExample" class="accordion-collapse collapse" data-bs-parent="#examplesAccordion">
                    <div class="accordion-body">
                        <pre class="bg-light p-3 rounded"><code>{
    "items": [
        {
            "number": 25000,
            "label": "{{__('Tickets Processed')}}"
        },
        {
            "number": 99,
            "label": "{{__('Customer Satisfaction')}}"
        }
    ]
}</code></pre>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#testimonialsExample">
                        {{__('Testimonials Example')}}
                    </button>
                </h2>
                <div id="testimonialsExample" class="accordion-collapse collapse" data-bs-parent="#examplesAccordion">
                    <div class="accordion-body">
                        <pre class="bg-light p-3 rounded"><code>{
    "title": "{{__('Trusted by Industry Leaders')}}",
    "subtitle": "{{__('See what our customers say...')}}",
    "items": [
        {
            "text": "{{__('SupportSystem transformed our...')}}",
            "author": "{{__('Sarah Johnson')}}",
            "position": "{{__('CTO, TechInnovate')}}",
            "avatar": "SJ"
        }
    ]
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('homepageForm').addEventListener('submit', function(e) {
    const contentTextarea = document.getElementById('content');
    try {
        JSON.parse(contentTextarea.value);
    } catch (error) {
        e.preventDefault();
        alert('{{__('Invalid JSON format! Please check your content.')}}');
        contentTextarea.focus();
    }
});

document.getElementById('imageInput').addEventListener('change', function(event) {
    let file = event.target.files[0];
    if (!file) return;
    let reader = new FileReader();
    reader.onload = function(e) {
        let preview = document.getElementById('previewImage');
        preview.src = e.target.result;
        preview.classList.remove('d-none');
    };
    reader.readAsDataURL(file);
});
</script>
@endpush

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    .page-header h1 {
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }
    pre code {
        font-size: 0.85rem;
    }
</style>
@endpush
@endsection