@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    {{-- Top Header / Action Bar --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark mb-1">Products Inventory</h2>
            <p class="text-muted small mb-0">Manage, filter, print, and track all  items.</p>
        </div>
        
        <div class="d-flex gap-2">
            {{-- Dynamic Bulk Delete Action --}}
            <button type="button" 
                    id="bulkDeleteBtn" 
                    class="btn btn-danger d-none align-items-center gap-2 shadow-sm">
                <i class="fa-solid fa-trash"></i>
                <span>Delete Selected (<span id="selectedCount">0</span>)</span>
            </button>

            <a href="{{ route('admin.products.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="fa-solid fa-plus"></i>
                <span>Add New Product</span>
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check fs-5 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Filters Card --}}
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.products.index') }}" method="GET">
                <div class="row g-3 align-items-center">
                    
                    {{-- Search Input --}}
                    <div class="col-12 col-md-3">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   class="form-control border-start-0 ps-0" 
                                   placeholder="Search name or chassis..."
                                   autocomplete="off">
                        </div>
                    </div>

                    {{-- Category Filter --}}
                    <div class="col-12 col-sm-6 col-md-2">
                        <select name="category" onchange="this.form.submit()" class="form-select text-secondary">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Brand Filter --}}
                    <div class="col-12 col-sm-6 col-md-2">
                        <select name="brand" onchange="this.form.submit()" class="form-select text-secondary">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status Filter --}}
                    <div class="col-12 col-sm-6 col-md-2">
                        <select name="status" onchange="this.form.submit()" class="form-select text-secondary">
                            <option value="">All Status</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Actual</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>General</option>
                        </select>
                    </div>

                    {{-- Actions: Clear & Print/Export --}}
                    <div class="col-12 col-md-3 d-flex justify-content-md-end align-items-center gap-2">
                        @if (request()->hasAny(['search', 'category', 'brand', 'status']))
                            <a href="{{ route('admin.products.index') }}" class="btn btn-link text-decoration-none text-danger btn-sm p-0 me-2">
                                <i class="fa-solid fa-xmark me-1"></i>Clear Filters
                            </a>
                        @endif

                        <button onclick="printDiv('printableArea')" type="button" class="btn btn-outline-secondary d-inline-flex align-items-center gap-1">
                            <i class="fa-solid fa-print"></i> Print
                        </button>

                        {{-- <button type="button" class="btn btn-outline-secondary d-inline-flex align-items-center gap-1">
                            <i class="fa-solid fa-file-export"></i> Export
                        </button> --}}
                        <button type="button" 
                            onclick="exportTableToCSV('printableArea', 'product_inventory.csv')" 
                            class="btn btn-info d-inline-flex align-items-center gap-1 text-white shadow-sm">
                        <i class="fa-solid fa-file-export"></i>
                        <span>Export CSV</span>
                    </button>

                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Main Inventory Table Card --}}
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <form id="bulkActionForm" action="{{ route('admin.products.productBulkDelete') }}" method="POST">
            @csrf
            @method('DELETE')

            <div id="printableArea" class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 40px;">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>Code</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Chassis #</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th class="text-end pe-4 hide-on-print">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="ps-4">
                                    <input type="checkbox" name="ids[]" value="{{ $product->id }}" class="product-checkbox form-check-input">
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace">{{ $product->product_code }}</span>
                                </td>
                                <td class="fw-semibold text-dark">{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td>{{ $product->brand->name ?? 'N/A' }}</td>
                                <td class="text-muted">{{ $product->ChassisNumber ?? '-' }}</td>
                                <td class="fw-bold">¥{{ number_format($product->price, 2) }}</td>
                                <td>
                                    @if($product->Status == 1)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1">Actual</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-2 py-1">General</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4 hide-on-print">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-warning btn-sm" title="Edit Product">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        
                                        <button type="button" 
                                                class="btn btn-outline-danger btn-sm single-delete-btn" 
                                                data-url="{{ route('admin.products.destroy', $product->id) }}"
                                                title="Delete Product">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fa-solid fa-box-open fs-1 mb-2"></i>
                                        <p class="mb-0">No products match your current criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    {{-- Pagination Footer --}}
    <div class="mt-4 d-flex justify-content-end">
        {{ $products->appends(request()->query())->links() }}
    </div>

</div>

{{-- Standalone Single Delete Form (To avoid form nesting issues) --}}
<form id="singleDeleteForm" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

{{-- Print stylesheet overlay --}}
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #printableArea, #printableArea * {
        visibility: visible;
    }
    #printableArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .hide-on-print {
        display: none !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.product-checkbox');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const selectedCountSpan = document.getElementById('selectedCount');
    const bulkForm = document.getElementById('bulkActionForm');
    const singleDeleteForm = document.getElementById('singleDeleteForm');

    // 1. Select / Deselect All
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateBulkButton();
        });
    }

    // 2. Individual Checkbox Updates
    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkButton);
    });

    // 3. Dynamic UI Sync
    function updateBulkButton() {
        const checkedCount = document.querySelectorAll('.product-checkbox:checked').length;
        if (selectedCountSpan) selectedCountSpan.textContent = checkedCount;

        if (checkedCount > 0) {
            bulkDeleteBtn.classList.remove('d-none');
            bulkDeleteBtn.classList.add('d-inline-flex');
        } else {
            bulkDeleteBtn.classList.add('d-none');
            bulkDeleteBtn.classList.remove('d-inline-flex');
            if (selectAll) selectAll.checked = false;
        }

        if (selectAll && checkboxes.length > 0) {
            selectAll.checked = (checkedCount === checkboxes.length);
        }
    }

    // 4. Bulk Delete Confirmation
    if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', function() {
            const checkedCount = document.querySelectorAll('.product-checkbox:checked').length;
            if (checkedCount > 0 && confirm(`Are you sure you want to delete ${checkedCount} selected product(s)?`)) {
                bulkForm.submit();
            }
        });
    }

    // 5. Single Row Deletion Trigger
    document.querySelectorAll('.single-delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this product?')) {
                singleDeleteForm.action = this.getAttribute('data-url');
                singleDeleteForm.submit();
            }
        });
    });
});


</script>
    <script> 
        function printDiv(divId){
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
        function exportTableToCSV(tableId, filename = 'products_export.csv') {
    const table = document.getElementById(tableId);
    if (!table) {
        console.error(`Table with ID "${tableId}" not found.`);
        return;
    }

    const rows = table.querySelectorAll('tr');
    let csvContent = [];

    rows.forEach(row => {
        let rowData = [];
        // Extract visible cells (th, td)
        const cols = row.querySelectorAll('th, td');

        cols.forEach((col, index) => {
            // OPTIONAL: Skip column 0 (Checkboxes) and column 8 (Actions)
            // Adjust these column indexes based on your table layout
            if (index === 0 || col.classList.contains('hide-on-print')) {
                return;
            }

            // Clean cell text: strip extra whitespace and replace newlines
            let text = col.innerText.trim().replace(/\r?\n|\r/g, ' ');

            // Escape double quotes by doubling them ("" -> "")
            text = text.replace(/"/g, '""');

            // Enclose field in double quotes to handle commas properly
            rowData.push(`"${text}"`);
        });

        // Only add non-empty rows
        if (rowData.length > 0) {
            csvContent.push(rowData.join(','));
        }
    });

    // Create a Blob with UTF-8 encoding (BOM included for Excel compatibility)
    const csvString = '\uFEFF' + csvContent.join('\n');
    const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });

    // Trigger standard browser download
    const link = document.createElement('a');
    if (navigator.msSaveBlob) { // IE 10+
        navigator.msSaveBlob(blob, filename);
    } else {
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', filename);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}
    </script>
@endsection