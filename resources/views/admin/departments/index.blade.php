@extends('layouts.admin')

@section('page-title', __('Departments'))

@section('content')
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="mb-2"><i class="fas fa-building me-2"></i>{{__('Departments')}}</h1>
            <p class="mb-0 opacity-75">{{__('Manage support departments')}}</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('admin.departments.create') }}" class="btn btn-light btn-lg">
                <i class="fas fa-plus-circle me-2"></i>{{__('Add Department')}}
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>{{__('All Departments')}}</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Description')}}</th>
                        <th>{{__('Actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $department)
                    <tr>
                        <td><strong>{{ $department->name }}</strong></td>
                        <td>{{ $department->description }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.departments.edit', $department->id) }}" class="btn btn-primary" title="{{__('Edit')}}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.departments.destroy', $department->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{__('Delete this department?')}}')">
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
                        <td colspan="3" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">{{__('No departments found')}}</p>
                            <a href="{{ route('admin.departments.create') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus-circle me-2"></i>{{__('Create Department')}}
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($departments instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="card-footer">
        {{ $departments->links() }}
    </div>
    @endif
 </div>
@endsection