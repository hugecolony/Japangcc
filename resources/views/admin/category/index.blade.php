@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">

        {{-- Flash Notification --}}

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check fs-5 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
   @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4 shadow-sm" role="alert">
            <i class="fa-solid fa-triangle-exclamation fs-5 me-2"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
        <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
            
            {{-- Header & Actions --}}
            <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
                <div>
                    <h4 class="mb-0 fw-bold text-dark">Category Management</h4>
                    <small class="text-muted">Manage your product categories</small>
                </div>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-plus"></i>
                    <span>Add Category</span>
                </a>
            </div>

            <div class="card-body p-4">

                {{-- Filter & Search Section --}}
                <div class="bg-light p-3 rounded-3 mb-4">
                    <form action="{{ route('admin.categories.index') }}" method="GET" class="row g-2 align-items-center">
                        <div class="col-md-5 col-lg-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}" 
                                       class="form-control border-start-0 bg-white ps-0" 
                                       placeholder="Search category name..."
                                       autocomplete="off">
                                
                                @if(request('search'))
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary" title="Clear Search">
                                        <i class="fa-solid fa-xmark"></i>
                                    </a>
                                @endif
                                
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>

                        @if(request('search'))
                            <div class="col-auto">
                                <span class="badge bg-white text-dark border p-2 fw-normal">
                                    Filtered by: "<strong>{{ request('search') }}</strong>"
                                </span>
                            </div>
                        @endif
                    </form>
                </div>


                <div class="table-responsive">
                    <table class="table table-hover align-middle border-top mb-0">
                        <thead class="table-light">
                            <tr>
                            <th>Category Code</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($categories as $category)
                                <tr>
                                    <td class="fw-bold text-muted"><span class="badge bg-secondary">{{ $category->category_code }}</span></td>
                                    <td><span class="badge bg-light text-dark border font-monospace px-2 py-1">
                                            {{ $category->id }}
                                        </span></td>
                                    <td class="fw-semibold text-dark" >{{ $category->name }}</td>
                                    <td>
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                        </form>
                                    </td>
                                    
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fa-solid fa-folder-open fs-1 mb-2"></i>
                                            <p class="mb-0">No categories found.</p>
                                            @if(request('search'))
                                                <small>Try clearing your search filters.</small>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $categories->links() }}
                </div>
            </div>
    </div>
 

@endsection