@extends('layouts.admin')


@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Create Brand</h4>
                    {{-- href="{{ route('admin.brands.create') }}" --}}
                    <a  href="{{ route('admin.brands.index') }}" class="btn btn-primary btn-sm float-end">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
        
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label >select category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">-- Select Category --</option>

                                    @foreach ($categories as $category)
                                        <option id="category_{{ $category->id }}" value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach 
                                    @error('category_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </select>
                            </div>
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                     
                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary float-end">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
    </div>

@endsection