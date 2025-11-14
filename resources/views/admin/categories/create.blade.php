@extends('layouts.admin')

@section('page-title', __('Create Category'))

@section('content')
<div class="page-header mb-4">
    <div>
        <h1 class="mb-2"><i class="fas fa-plus-circle me-2"></i>{{__('Create Category')}}</h1>
        <p class="mb-0 opacity-75">{{__('Add a new ticket category')}}</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">{{__('Name')}} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">{{__('Department')}}</label>
                <select class="form-select" name="department_id">
                    <option value="">{{__('None')}}</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">{{__('Description')}}</label>
                <textarea class="form-control" name="description" rows="3"></textarea>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{__('Back')}}
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>{{__('Create Category')}}
                </button>
            </div>
        </form>
    </div>
 </div>
@endsection