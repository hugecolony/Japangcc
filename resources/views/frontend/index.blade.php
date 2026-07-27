<!DOCTYPE html>
<html>
<head>

    <title>Japan GCC</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        // Same logo used in the DomPDF report, reused here for the
        // client-side pdfMake "Quick PDF" button so both exports match.
        $logoPath = public_path('logo.jpg');

        $companyLogoBase64 = null;

        if (file_exists($logoPath)) {
            $type = pathinfo($logoPath, PATHINFO_EXTENSION);
            $companyLogoBase64 = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($logoPath));
        }
    @endphp
    <script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <link href="https://cdn.datatables.net/3.0.0/css/dataTables.bootstrap5.min.css" rel="stylesheet" integrity="sha384-OlHQFPrLwnmeXJfLPQ4jqFbOgPdCIW0hRoNKjPLyIZv7FxVwt3dythZstNHJQRtV" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/colreorder/3.0.0/css/colReorder.bootstrap5.min.css" rel="stylesheet" integrity="sha384-GbOIUvtTgiwI6/J1RPbHEigVcEHKQ5rwIoEmihz+slAsiIn6KTkzPQbdMneBryUS" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/rowreorder/2.0.0/css/rowReorder.bootstrap5.min.css" rel="stylesheet" integrity="sha384-DuRJHQ3yS+VNUfWLOxOfsz5P5MXlC9P5ZH//602/D+CPVWNVJ4bNNHa9acZIE0kO" crossorigin="anonymous">

    <script src="https://cdn.datatables.net/3.0.0/js/dataTables.min.js" integrity="sha384-sypcith22D39SW1DIZDD9dTBuo6cx/JfHuiN7WLLSVpX7WbUn5NpHD8T0OmbmGLb" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/3.0.0/js/dataTables.bootstrap5.min.js" integrity="sha384-4d8X9sr6Gnv9AgIQn6bv3lmQxj5fD+9bVAun0/XMmdy7oPRvT0adfiUUiiYpi4Ck" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/colreorder/3.0.0/js/dataTables.colReorder.min.js" integrity="sha384-1l/GaUSavYFcE3PG7Hl4gFHwmXBonKsK0KdeQ7TtI82SpfhxYVt2mRQrr9cgGBwr" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/rowreorder/2.0.0/js/dataTables.rowReorder.min.js" integrity="sha384-3FdX9znSzy1WxZzKoiWmFdwcPGaVYTB9+XDn6iubOdNxM65jGBH0JHZtdR4rp4o/" crossorigin="anonymous"></script>
    <link href="https://cdn.datatables.net/buttons/4.0.0/css/buttons.bootstrap5.min.css" rel="stylesheet" integrity="sha384-bYPwNBWmi1WFXmRpFZBo/GIeUEOJhbZ+Lcavx5JEeGMZVFxBtV7+FXUtsJZd/+yD" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" integrity="sha384-VFQrHzqBh5qiJIU0uGU5CIW3+OWpdGGJM9LBnGbuIH2mkICcFZ7lPd/AAtI7SNf7" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" integrity="sha384-/RlQG9uf0M2vcTw3CX7fbqgbj/h8wKxw7C3zu9/GxcBPRKOEcESxaxufwRXqzq6n" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/buttons/4.0.0/js/dataTables.buttons.min.js" integrity="sha384-y5+we4jhNtBBFF4854lUCYbGItWlNesg0mMj8l5GYoTL2poziIPvO5bKAc4ef3v1" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/buttons/4.0.0/js/buttons.bootstrap5.min.js" integrity="sha384-dmbHEghlFCkuvUHLeAFn8Jy5olkP5YDFOuF/lOQM+oFviSc5ODSSXBZDN1IQfKau" crossorigin="anonymous"></script>

    <style>
        body {
            font-size: 0.75rem !important;
            background-color: #f8f9fa;
        }
        .table-compact-custom {
            width: 100% !important;
            white-space: nowrap;
        }
        .table-compact-custom th,
        .table-compact-custom td {
            padding: 4px 6px !important;
            font-size: 11px !important;
            vertical-align: middle !important;
        }
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            font-size: 12px !important;
            margin-bottom: 5px;
        }
        table tr {
            vertical-align: middle;
        }
        #overlay-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
            z-index: 999;
            display: none; /* hidden by default, shown via JS during ajax calls */
        }
        #loader {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
        #loader #img {
            width: 100px;
        }
        .dt-processing {
            display: none !important;
        }
    </style>
</head>
<body>

<div class="container-fluid mt-3 px-4">
    <h5 class="text-center mb-3 fw-bold text-secondary">Japan GCC - Product Registry</h5>

    <div class="table-responsive shadow-sm bg-white p-2 rounded border">
        <div id="overlay-loader">
            <div id="loader">
                <img id="img" src="{{ asset('assets/loader.gif') }}"/>
            </div>
        </div>

        <div class="row mb-4 border-bottom pd-4">
            <div class="col-xl-8 d-flex">
                <div class="form-group w-100">
                    <label for="start-date">Start Date </label>
                    <input type="date" class="form-control" id="start-date" name="startDate"/>
                </div>

                <div class="form-group w-100 ms-4">
                    <label for="end-date">End Date </label>
                    <input type="date" class="form-control" id="end-date" name="endDate"/>
                </div>

                <div class="form-group ms-4 d-flex align-items-end">
                    {{-- Plain navigation link to the server-side DomPDF report route.
                         Not AJAX — the browser just downloads the file directly.
                         This always includes the FULL filtered dataset (not just the
                         current on-screen page), unlike the client-side pdfMake button
                         further down, which can only see currently-loaded rows when
                         serverSide:true is active. --}}

                    <a href="{{ route('admin.dashboard') }}" class="btn btn-success" target="_blank">
                        <i class="fa-solid fa-door-open"></i> Go to dashboard
                    </a>
                    <a id="export-pdf-report-btn" href="{{ route('frontend.frontendpdf') }}" class="btn btn-danger" target="_blank">
                        <i class="fa-solid fa-file-pdf me-1"></i> Export Full PDF Report
                    </a>
                </div>
            </div>
        </div>

        <table class="table table-sm table-striped table-bordered table-hover table-compact-custom datatable m-0">
            <thead class="table-light">
                <tr>
                    <th>Product Code</th>
                    <th>Category Name</th>
                    <th>Brand Name</th>
                    <th>Name</th>
                    <th>Purchase Price (Yuan)</th>
                    <th>Chassis Number</th>
                    <th>Engine Number</th>
                    <th>Year</th>
                    <th>Score</th>
                    <th>Grade</th>
                    <th>CC</th>
                    <th>Color</th>
                    <th>WD</th>
                    <th>Transmission</th>
                    <th>Odo</th>
                    <th>Status</th>
                    <th>Created At</th>
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
        </table>
    </div>
</div>

</body>

<script type="text/javascript">

$(document).ready(function () {

    // Same branding used in the DomPDF report — kept in sync so both
    // export paths look consistent.
    const COMPANY_NAME = @json(config('app.name', 'Japan GCC'));
    const COMPANY_LOGO = @json($companyLogoBase64); // null if logo.png wasn't found
    const COMPANY_ADDR = "12-4 Corporate Boulevard, Chiyoda City, Tokyo, Japan";

    const table = $('.datatable').DataTable({
        colReorder: true,
        rowReorder: {
            update: false,
            selector: 'tr'
        },
        serverSide: true,
        processing: true,
        ajax: {
            beforeSend: function () {
                $('#overlay-loader').show();
            },
            url: '{{ route("frontend.index") }}',
            data: function (payload) {
                const startDate = $('#start-date').val();
                const endDate = $('#end-date').val();
                payload.startDate = startDate;
                payload.endDate = endDate;
            },
            type: 'GET'
        },

        columns: [
            { data: 'product_code', name: 'product_code' },
            { data: 'category.name', name: 'category.name', defaultContent: 'N/A' },
            { data: 'brand.name', name: 'brand.name', defaultContent: 'N/A' },
            { data: 'name', name: 'name' },
            { data: 'price', name: 'price' },
            { data: 'ChassisNumber', name: 'ChassisNumber' },
            { data: 'EngineNumber', name: 'EngineNumber' },
            { data: 'Year', name: 'Year' },
            { data: 'Score', name: 'Score' },
            { data: 'AuctionGrade', name: 'AuctionGrade' },
            { data: 'CC', name: 'CC' },
            { data: 'Color', name: 'Color' },
            { data: 'WD', name: 'WD' },
            { data: 'Transmission', name: 'Transmission' },
            { data: 'ODOMeter', name: 'ODOMeter' },
            {
                data: 'Status',
                name: 'Status',
                render: function (data) {
                    return data == 1
                        ? '<span class="badge bg-success">Actual : 1</span>'
                        : '<span class="badge bg-secondary">General : 0</span>';
                }
            },
            { data: 'created_at', name: 'created_at' , orderable: false, searchable: false },
            // { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        responsive: true,
        autoWidth: false,
        dom: '<"d-flex justify-content-between"lfB>rtip',

        buttons: [
            {
                extend: 'csv',
                text: 'Export Excel (this page)',
                exportOptions: { columns: ':not(:last-child)' }
            },
            {
                extend: 'pdf',
                text: '<i class="fa-solid fa-file-pdf me-1"></i> Quick PDF (this page)',
                className: 'btn btn-sm btn-outline-danger',
                title: null, // suppressed — we build our own title inside the header below
                orientation: 'portrait',
                pageSize: 'A3',
                exportOptions: { columns: ':not(:last-child)' },
                // Note: with serverSide:true, this only exports rows currently
                // loaded on screen. Use "Export Full PDF Report" above for the
                // complete filtered dataset with your branded header/footer.

                customize: function (doc) {
                    // Room at top/bottom for the header/footer blocks below
                    doc.pageMargins = [30, 100, 30, 60];

                    doc.header = function (currentPage, pageCount) {
                        return {
                            margin: [30, 20, 30, 0],
                            stack: [
                                {
                                    columns: [
                                        COMPANY_LOGO
                                            ? {
                                                columns: [
                                                    { image: COMPANY_LOGO, width: 40, height: 40 },
                                                    { text: COMPANY_NAME, style: 'companyName', margin: [8, 10, 0, 0] }
                                                ],
                                                width: '*'
                                            }
                                            : { text: COMPANY_NAME, style: 'companyName', width: '*' },
                                        { text: 'PRODUCT REGISTRY (Quick Export)', style: 'reportTitle', alignment: 'right', width: '*' }
                                    ]
                                },
                                {
                                    columns: [
                                        { text: COMPANY_ADDR, style: 'companySub', width: '*' },
                                        { text: 'Generated: ' + new Date().toLocaleString(), style: 'companySub', alignment: 'right', width: '*' }
                                    ]
                                },
                                { canvas: [{ type: 'line', x1: 0, y1: 5, x2: 780, y2: 5, lineWidth: 1, lineColor: '#333333' }] }
                            ]
                        };
                    };

                    doc.footer = function (currentPage, pageCount) {
                        return {
                            margin: [30, 10, 30, 0],
                            stack: [
                                { canvas: [{ type: 'line', x1: 0, y1: 0, x2: 780, y2: 0, lineWidth: 0.5, lineColor: '#999999' }] },
                                {
                                    columns: [
                                        { text: COMPANY_NAME + ' — Confidential (page-only export)', style: 'footerText', width: '*' },
                                        { text: 'Page ' + currentPage + ' of ' + pageCount, style: 'footerText', alignment: 'right', width: '*' }
                                    ],
                                    margin: [0, 6, 0, 0]
                                }
                            ]
                        };
                    };

                    doc.styles.companyName = { fontSize: 14, bold: true, color: '#222222' };
                    doc.styles.reportTitle = { fontSize: 12, bold: true, color: '#c0392b' };
                    doc.styles.companySub  = { fontSize: 8, color: '#666666' };
                    doc.styles.footerText  = { fontSize: 8, color: '#666666' };

                    if (doc.content[1] && doc.content[1].table) {
                        doc.content[1].table.headerRows = 1;
                        doc.content[1].layout = {
                            fillColor: function (rowIndex) {
                                return rowIndex === 0 ? '#f0f0f0' : (rowIndex % 2 === 0 ? '#fafafa' : null);
                            },
                            hLineColor: () => '#dddddd',
                            vLineColor: () => '#dddddd'
                        };
                    }
                }
            },
            {
                extend: 'print',
                text: 'Print (this page)',
                exportOptions: { columns: ':not(:last-child)' }
            },
        ],
        drawCallback: function () {
            $('#overlay-loader').hide();
        }
    });

    // Build a second header row of per-column search inputs
    const inputSearchRow = $('.datatable thead tr').clone(true).appendTo('.datatable thead');
    inputSearchRow.find('th').each(function (index) {
        if (index === 0 || index === inputSearchRow.find('th').length - 1) {
            $(this).html('');
            return;
        }
        $(this).html(`<input type="text" class="form-control filter-input" placeholder="Search ${$(this).text()}"/>`);
    });

    // FIXED: was $('input-filter') — missing the leading dot meant this
    // never matched anything, so per-column search boxes did nothing.
    $('.datatable thead').on('keyup change', '.filter-input', function () {
        const columnIndex = $(this).closest('th').index();
        const searchedTerm = $(this).val().trim();
        table.column(columnIndex).search(searchedTerm).draw();
    });

    // Date filter change -> reload table AND keep the PDF export link in sync
    // so "Export Full PDF Report" downloads the same date range you're viewing
    $("#start-date, #end-date").on('change', function () {
        const startDate = $('#start-date').val();
        const endDate = $('#end-date').val();

        if (startDate && endDate) {
            table.draw();

            const url = new URL(document.getElementById('export-pdf-report-btn').href, window.location.origin);
            url.searchParams.set('startDate', startDate);
            url.searchParams.set('endDate', endDate);
            document.getElementById('export-pdf-report-btn').href = url.toString();
        }
    });

    // Stop sort-toggle firing when clicking inside the search-input row
    $('.datatable thead tr:nth-child(2) th').on('click', function (event) {
        event.stopPropagation();
    });

    // Delete product
    $('.datatable').on('click', '.delete-user', function () {
        const userId = $(this).data('id');
        if (!userId) return;

        if (confirm('Are you sure you want to delete this product?')) {
            $.ajax({
                url: `/frontend/${userId}`,
                method: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function (response) {
                    if (response.status === 'success') {
                        table.ajax.reload(null, false);
                    } else {
                        alert(response.message);
                    }
                },
                error: function () {
                    alert('Something went wrong');
                }
            });
        }
    });

    // Print invoice button -> opens the single-product PDF invoice route
    $('.datatable').on('click', '.btn-print-invoice', function () {
        const productId = $(this).data('id');
        window.open(`/frontend/invoice/${productId}`, '_blank');
    });

});
</script>

</html>