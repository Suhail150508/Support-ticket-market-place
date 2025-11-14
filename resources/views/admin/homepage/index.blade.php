@extends('layouts.admin')

@section('page-title', __('Home Page Content Management'))

@section('content')
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="mb-2"><i class="fas fa-home me-2"></i>{{__('Home Page Content')}}</h1>
            <p class="mb-0 opacity-75">{{__('Manage all sections of your home page')}}</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('admin.homepage.create') }}" class="btn btn-light btn-lg">
                <i class="fas fa-plus-circle me-2"></i>{{__('Add New Section')}}
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>{{__('All Sections')}}</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>{{__('Section Key')}}</th>
                        <th>{{__('Section Name')}}</th>
                        <th>{{__('Status')}}</th>
                        <th>{{__('Sort Order')}}</th>
                        <th>{{__('Updated')}}</th>
                        <th>{{__('Actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sections as $section)
                    <tr>
                        <td><strong>{{ $section->section_key }}</strong></td>
                        <td>{{ $section->section_name }}</td>
                        <td>
                            <span class="badge {{ $section->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $section->is_active ? __('Active') : __('Inactive') }}
                            </span>
                        </td>
                        <td>{{ $section->sort_order }}</td>
                        <td><small>{{ $section->updated_at->format('M d, Y H:i') }}</small></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.homepage.edit', $section->id) }}" class="btn btn-primary" title="{{__('Edit')}}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.homepage.destroy', $section->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{__('Are you sure you want to delete this section?')}}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="{{__('Delete')}}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">{{__('No sections found. Create your first section!')}}</p>
                            <a href="{{ route('admin.homepage.create') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus-circle me-2"></i>{{__('Create Section')}}
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

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