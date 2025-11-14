@extends('layouts.admin')

@section('page-title', __('Categories'))

@section('content')
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="mb-2"><i class="fas fa-tags me-2"></i>{{__('Categories')}}</h1>
            <p class="mb-0 opacity-75">{{__('Manage ticket categories')}}</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-light btn-lg">
                <i class="fas fa-plus-circle me-2"></i>{{__('Add Category')}}
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>{{__('All Categories')}}</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Department')}}</th>
                        <th>{{__('Description')}}</th>
                        <th>{{__('Actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td>{{ optional($category->department)->name ?? '-' }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary" title="{{__('Edit')}}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{__('Delete this category?')}}')">
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
                        <td colspan="4" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">{{__('No categories found')}}</p>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus-circle me-2"></i>{{__('Create Category')}}
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($categories instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="card-footer">
        {{ $categories->links() }}
    </div>
    @endif
 </div>
@endsection