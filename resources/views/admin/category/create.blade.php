@extends('layouts.admin')


@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Create Category</h4>
                    {{-- href="{{ route('admin.categories.create') }}" --}}
                    <a  href="{{ route('admin.categories.index') }}" class="btn btn-primary btn-sm float-end">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6 mb-3">
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