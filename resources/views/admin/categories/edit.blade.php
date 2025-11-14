@extends('layouts.admin')

@section('page-title', __('Edit Category'))

@section('content')
<div class="page-header mb-4">
    <div>
        <h1 class="mb-2"><i class="fas fa-edit me-2"></i>{{__('Edit Category')}}</h1>
        <p class="mb-0 opacity-75">{{__('Update ticket category details')}}</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">{{__('Name')}} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $category->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">{{__('Department')}}</label>
                <select class="form-select" name="department_id">
                    <option value="">{{__('None')}}</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ (int) old('department_id', $category->department_id) === $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">{{__('Description')}}</label>
                <textarea class="form-control" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{__('Back')}}
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>{{__('Update Category')}}
                </button>
            </div>
        </form>
    </div>
 </div>
@endsection