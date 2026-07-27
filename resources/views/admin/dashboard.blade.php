@extends('layouts.admin')




@section('content')


<div class="row mb-4">
    <div class="col-md-12 grid-margin">
        
        {{-- Flash Success Message --}}
        @if(session('message'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
                <i class="mdi mdi-check-circle me-2 fs-4"></i>
                <div>{{ session('message') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        
                {{-- Top Bar & Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <div>
                    <h2 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name ?? 'Manager' }} 👋</h2>
                    <div class="d-flex align-items-center text-muted small">
                        <i class="mdi mdi-home text-primary me-1"></i>
                        <span class="text-primary fw-semibold">Dashboard</span>
                        <span class="mx-2">/</span>
                        <span>Overview</span>
                    </div>
                </div>

                  {{-- Quick Actions --}}
              <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                  <a href="{{ route('admin.products.create') }}" class="btn btn-primary d-flex align-items-center gap-1 shadow-sm">
                      <i class="mdi mdi-plus fs-5"></i> Add New Product
                  </a>
                  <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                      <i class="mdi mdi-car fs-5"></i> View Inventory
                  </a>
              </div>
            </div>
            {{-- Live Metrics Cards --}}
        <div class="row g-3">
            
            {{-- Card 1: Total Products --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-3">
                
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            
                            <div>
                                <p class="text-muted fw-medium mb-1">Total Products</p>
                                
                                <h2 class="fw-bold mb-0">{{ $products->COUNT('id') ?? 0 }}</h2> 
                                <br/>
                                        <a  href="{{ route('admin.products.index') }}"  class="btn btn-primary border-amber-300">View All Products</a>

                            </div>
                            <div class="badge bg-primary-subtle text-primary p-3 rounded-circle">
                                <i class="mdi mdi-car-multiple fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Card 2: Actual Units --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted fw-medium mb-1">Actual Products</p>
                                <h3 class="fw-bold mb-0 text-success">{{ $products->where('Status', 1)->count() ?? 1 }}</h3>
                            </div>
                            <div class="badge bg-success-subtle text-success p-3 rounded-circle">
                                <i class="mdi mdi-check-decagram fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted fw-medium mb-1">General Products</p>
                                <h3 class="fw-bold mb-0 text-success">{{ $products->where('Status', 0)->count() ?? 0 }}</h3>
                            </div>
                            <div class="badge bg-success-subtle text-success p-3 rounded-circle">
                                <i class="mdi mdi-check-decagram fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>









            

            </div>
        </div>
      </div>
    
@endsection