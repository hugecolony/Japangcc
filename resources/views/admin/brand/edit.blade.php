@extends('layouts.admin')


@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Brand</h4>
                    {{-- href="{{ route('admin.brands.create') }}" --}}
                    <a  href="{{ route('admin.brands.index') }}" class="btn btn-primary btn-sm float-end">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.brands.update', $Brand->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                     
                         <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $Brand->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->category_code }} - {{ $category->name }}
                </option>
            @endforeach
        </select>
        <small class="text-muted">
            Changing category regenerates this brand's code (e.g. 01-01 → 02-03).
            Existing products under this brand keep their current codes — they are not renumbered.
        </small>
    </div>
 
                         {{-- <div class="form-group">
                            
                                <label >Select category</label>
                                <select name="category_id" class="form-control">
                                    @foreach ($categories as $category)

                                        <option id="category_{{ $category->id }}" value="{{ $category->id }}" {{ $Brand->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach 
                                    @error('category_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </select>
                            </div> --}}
                            <label for="name" class="form-label">Brand Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $Brand->name }}" required>
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