@extends('layouts.admin')


@section('content')
<div class="container py-4">
   
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Create Product</h4>
                    {{-- href="{{ route('admin.brands.create') }}" --}}
                    <a  href="{{ route('admin.products.index') }}" class="btn btn-primary btn-sm float-end">Back</a>
                </div>
<div class="card-body"> 
        
        @if($errors->any())
            <div class="alert alert-warning">
                @foreach($errors->all() as $error)
                        <div>{{$error}} </div>
                </div>
                @endforeach

        @endif

    {{-- Form 1: Category Selection Trigger --}}
    <form action="{{ route('admin.products.create') }}" method="GET" enctype="multipart/form-data">
        <label for="category_id" class="form-label">Select Category</label>
        <select name="category_id" id="category_id" class="form-select" onchange="this.form.submit()">
            <option value="">-- Select Category --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $selectedCategoryId == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <noscript><button type="submit" class="btn btn-sm btn-secondary mt-2">Filter Brands</button></noscript>
    </form>

    {{-- Form 2: Product Creation --}}
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="category_id" value="{{ $selectedCategoryId }}">

        
        {{-- Brand Dropdown --}}
        
        <div class="mb-3">
            <label for="brand_id" class="form-label">Select Brand</label>
            <select name="brand_id" id="brand_id" class="form-select" {{ $brands->isEmpty() ? 'disabled' : '' }} required>
                <option value="">
                    {{ empty($selectedCategoryId) ? '-- Select Category First --' : '-- Select Brand --' }}
                </option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
{{-- Product Code --}}

                    {{-- Name --}}
                    <div class="col-md-4">
                        <label class="form-label">Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    {{-- Purchase Price --}}
                    <div class="col-md-6">
                        <label class="form-label">Price *</label>
                        <input type="integer"  name="price" value="{{ old('price', '1') }}" class="form-control" >
                        @error('price') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label">Status *</label>
                        <select name="Status" class="form-select">
                            <option value="0" {{ old('Status', 0) == 0 ? 'selected' : '' }}>0: General</option>
                            <option value="1" {{ old('Status') == 1 ? 'selected' : '' }}>1: Actual</option>
                        </select>
                    </div>

                    {{-- Chassis & Engine Numbers --}}
                    <div class="col-md-6">
                        <label class="form-label">Chassis Number</label>
                        <input type="text" name="ChassisNumber" value="{{ old('ChassisNumber') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Engine Number</label>
                        <input type="text" name="EngineNumber" value="{{ old('EngineNumber') }}" class="form-control">
                    </div>

                    {{-- Color, Year, CC, WD --}}
                    <div class="col-md-3">
                        <label class="form-label">Color</label>
                        <input type="text" name="Color" value="{{ old('Color') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Year</label>
                        <input type="text" name="Year" value="{{ old('Year') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">CC</label>
                        <input type="number" name="CC" value="{{ old('CC') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">WD</label>
                        <input type="text" name="WD" value="{{ old('WD') }}" class="form-control">
                    </div>

                    {{-- Transmission, Pickup Yard, Supplier --}}
                    <div class="col-md-4">
                        <label class="form-label">Transmission</label>
                        <input type="text" name="Transmission" value="{{ old('Transmission') }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pickup Yard</label>
                        <input type="text" name="PickupYard" value="{{ old('PickupYard') }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Supplier</label>
                        <input type="text" name="Supplier" value="{{ old('Supplier') }}" class="form-control">
                    </div>

                    {{-- ODO Meter, Score, Auction Grade, Invoice --}}
                    <div class="col-md-3">
                        <label class="form-label">ODO Meter</label>
                        <input type="text" name="ODOMeter" value="{{ old('ODOMeter') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Score</label>
                        <input type="text" name="Score" value="{{ old('Score') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Auction Grade</label>
                        <input type="text" name="AuctionGrade" value="{{ old('AuctionGrade') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Invoice Number</label>
                        <input type="text" name="InvoiceNumber" value="{{ old('InvoiceNumber') }}" class="form-control">
                    </div>

                    {{-- Remarks --}}
                    <div class="col-md-12">
                        <label class="form-label">Remarks</label>
                        <textarea name="Remarks" class="form-control" rows="3">{{ old('Remarks') }}</textarea>
                    </div>
                </div>
        <button type="submit" class="btn btn-primary" {{ empty($selectedCategoryId) ? 'disabled' : '' }}>
            Save Product
        </button>
    </form>
    </div>
</div>
@endsection

