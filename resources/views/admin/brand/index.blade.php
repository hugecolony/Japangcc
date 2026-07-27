

@extends('layouts.admin')


@section('content')

   <div class="row">
        <div class="col-md-12">
        @session('status')
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endsession
            <div class="card">
                <div class="card-header">
                    <h4>Brands List </h4>
                    {{-- href="{{ route('admin.brands.create') }}" --}}
                    <a  href="{{ route('admin.brands.create') }}" class="btn btn-primary btn-sm float-end">Add Brand</a>
                </div>
               <div class="bg-light p-3 rounded-3 mb-4">
                    <form action="{{ route('admin.brands.index') }}" method="GET" class="row g-2 align-items-center">
                        <div class="col-md-5 col-lg-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}" 
                                       class="form-control border-start-0 bg-white ps-0" 
                                       placeholder="Search brands name..."
                                       autocomplete="off">
                                
                                @if(request('search'))
                                    <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary" title="Clear Search">
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


                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Brand Code</th>
                                <th>ID</th>
                                <th>Category</th>
                                <th> Brand Name</th>       
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $brand)
                                <tr>
                                  <td><span class="badge bg-secondary">{{ $brand->brand_code }}</span></td>

                                    <td>{{ $brand->id }}</td>
                                    <td>{{ $brand->category ? $brand->category->name : 'No Category' }}</td>
                                    <td>{{ $brand->name }}</td>
                                    <td>
                                        <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this brand?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                    {{ $brands->links() }}  
                </div>
            </div>
    </div>
 

@endsection