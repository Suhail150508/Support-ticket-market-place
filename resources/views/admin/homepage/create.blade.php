@extends('layouts.admin')

@section('page-title', __('Create Home Page Section'))

@section('content')
<div class="page-header mb-4">
    <div>
        <h1 class="mb-2"><i class="fas fa-plus-circle me-2"></i>{{__('Create New Section')}}</h1>
        <p class="mb-0 opacity-75">{{__('Add a new section to your home page')}}</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-cog me-2"></i>{{__('Section Details')}}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.homepage.store') }}" method="POST" id="homepageForm">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{__('Section Key')}} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="section_key" required placeholder="{{__('e.g., hero, features, stats')}}">
                    <small class="text-muted">{{__('Unique identifier for this section (lowercase, no spaces)')}}</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{__('Section Name')}} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="section_name" required placeholder="{{__('e.g., Hero Section')}}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{__('Sort Order')}}</label>
                    <input type="number" class="form-control" name="sort_order" value="0">
                </div>
               <div class="col-md-6">
                    <label class="form-label fw-semibold">{{__('Status')}}</label>
                    <div class="form-check form-switch mt-2">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">{{__('Active')}}</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">{{__('Content (JSON)')}} <span class="text-danger">*</span></label>
                <textarea class="form-control font-monospace" name="content" id="content" rows="15" required placeholder='{"title": "{{__("Example")}}", "content": "..."}'></textarea>
                <small class="text-muted">{{__('Enter valid JSON format. See examples in the edit page.')}}</small>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.homepage.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{__('Back')}}
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>{{__('Create Section')}}
                </button>
            </div>
        </form>
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
</style>
@endpush
@endsection