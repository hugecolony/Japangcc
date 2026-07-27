@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    {{-- Top Header / Action Bar --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark mb-1">Edit Product</h2>
            <p class="text-muted small mb-0">Update information and vehicle details for ID #{{ $products->id }}</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Inventory</span>
        </a>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check fs-5 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <div class="d-flex align-items-center mb-1">
                <i class="fa-solid fa-triangle-exclamation fs-5 me-2"></i>
                <strong class="me-auto">Please correct the following errors:</strong>
            </div>
            <ul class="mb-0 ps-4 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Category Selection Form (GET) --}}
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.products.edit', $products) }}" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" onchange="this.form.submit()">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ (int) $selectedCategoryId === $category->id ? 'selected' : '' }}>
                                    {{ $category->category_code }} - {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted mt-1 d-block">
                            <i class="fa-solid fa-circle-info me-1"></i>
                            Changing category reloads the Brand list below. Nothing is saved until you click "Update Product".
                        </small>
                    </div>
                    <div class="col-md-4 mt-2 mt-md-0">
                        <noscript>
                            <button type="submit" class="btn btn-outline-secondary w-100">Load Brands</button>
                        </noscript>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Main Update Form (PUT) --}}
    <form action="{{ route('admin.products.update', $products) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Hidden Category Input to persist selected Category --}}
        <input type="hidden" name="category_id" value="{{ $selectedCategoryId }}">

        <div class="row g-4">
            
            {{-- Left Column: General & Specs --}}
            <div class="col-lg-8">
                
                {{-- General Details Card --}}
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="card-title fw-bold text-dark mb-0">
                            <i class="fa-solid fa-box text-primary me-2"></i>General Details
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            
                            {{-- Brand Selection (Filtered Server-Side) --}}
                            <div class="col-md-12">
                                <label for="brand_id" class="form-label fw-semibold">Select Brand <span class="text-danger">*</span></label>
                                <select name="brand_id" id="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
                                    @forelse ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $products->brand_id == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->brand_code }} - {{ $brand->name }}
                                        </option>
                                    @empty
                                        <option value="">-- No brands in this category --</option>
                                    @endforelse
                                </select>
                                @error('brand_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Product Name --}}
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $products->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Price & Status --}}
                            <div class="col-md-6">
                                <label for="price" class="form-label fw-semibold">Price <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">¥</span>
                                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $products->price) }}" class="form-control @error('price') is-invalid @enderror" required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="Status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                <select name="Status" id="Status" class="form-select @error('Status') is-invalid @enderror" required>
                                    <option value="0" {{ old('Status', $products->Status) == 0 ? 'selected' : '' }}>0: General</option>
                                    <option value="1" {{ old('Status', $products->Status) == 1 ? 'selected' : '' }}>1: Actual</option>
                                </select>
                                @error('Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Vehicle Specs Card --}}
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="card-title fw-bold text-dark mb-0">
                            <i class="fa-solid fa-car text-primary me-2"></i>Vehicle Specifications
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-secondary small">Chassis Number</label>
                                <input type="text" name="ChassisNumber" value="{{ old('ChassisNumber', $products->ChassisNumber) }}" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-secondary small">Engine Number</label>
                                <input type="text" name="EngineNumber" value="{{ old('EngineNumber', $products->EngineNumber) }}" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label text-secondary small">Color</label>
                                <input type="text" name="Color" value="{{ old('Color', $products->Color) }}" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label text-secondary small">Year</label>
                                <input type="text" name="Year" value="{{ old('Year', $products->Year) }}" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label text-secondary small">CC</label>
                                <input type="number" name="CC" value="{{ old('CC', $products->CC) }}" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label text-secondary small">WD</label>
                                <label for="WD" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                <select name="WD" id="Status" class="form-select @error('WD') is-invalid @enderror" required>
                                    <option value="2WD" {{ old('WD', $products->WD) == '2WD' ? 'selected' : '' }}> 2WD</option>
                                    <option value="4WD" {{ old('WD', $products->WD) == '4WD' ? 'selected' : '' }}> 4WD</option>
                                </select>
                                @error('Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                {{-- <input type="text" name="WD" value="{{ old('WD', $products->WD) }}" class="form-control">
                             --}}
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-secondary small">Transmission</label>
                                <input type="text" name="Transmission" value="{{ old('Transmission', $products->Transmission) }}" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-secondary small">ODO Meter</label>
                                <input type="text" name="ODOMeter" value="{{ old('ODOMeter', $products->ODOMeter) }}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right Column: Logistics & Actions --}}
            <div class="col-lg-4">
                
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="card-title fw-bold text-dark mb-0">
                            <i class="fa-solid fa-clipboard-list text-primary me-2"></i>Logistics & Grading
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label text-secondary small">Pickup Yard</label>
                                <input type="text" name="PickupYard" value="{{ old('PickupYard', $products->PickupYard) }}" class="form-control">
                            </div>

                            <div class="col-12">
                                <label class="form-label text-secondary small">Supplier</label>
                                <input type="text" name="Supplier" value="{{ old('Supplier', $products->Supplier) }}" class="form-control">
                            </div>

                            <div class="col-12">
                                <label class="form-label text-secondary small">Invoice Number</label>
                                <input type="text" name="InvoiceNumber" value="{{ old('InvoiceNumber', $products->InvoiceNumber) }}" class="form-control">
                            </div>

                            <div class="col-6">
                                <label class="form-label text-secondary small">Score</label>
                                <input type="text" name="Score" value="{{ old('Score', $products->Score) }}" class="form-control">
                            </div>

                            <div class="col-6">
                                <label class="form-label text-secondary small">Auction Grade</label>
                                <input type="text" name="AuctionGrade" value="{{ old('AuctionGrade', $products->AuctionGrade) }}" class="form-control">
                            </div>

                            <div class="col-12">
                                <label class="form-label text-secondary small">Remarks</label>
                                <textarea name="Remarks" class="form-control" rows="4">{{ old('Remarks', $products->Remarks) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit Action Card --}}
                <div class="card border-0 shadow-sm rounded-3 bg-light">
                    <div class="card-body p-4">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Update Product
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection