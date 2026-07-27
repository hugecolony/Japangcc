<!DOCTYPE html>
<html>
<head>
    <title>Japan GCC - Executive Product Registry</title>
    <style>
        @page { margin: 20px 25px; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10px; color: #333; margin: 0; padding: 0; }

        /* Layout Header Section */
        .company-header { width: 100%; border-bottom: 2px solid #1a365d; padding-bottom: 12px; margin-bottom: 15px; }
        .logo-box { width: 35%; vertical-align: top; }
        .logo-placeholder { font-size: 24px; font-weight: bold; color: #1a365d; letter-spacing: 1px; }
        .address-box { width: 65%; text-align: right; font-size: 10px; color: #4a5568; line-height: 1.4; }
        .report-title { font-size: 14px; font-weight: bold; color: #2b6cb0; text-transform: uppercase; margin-top: 15px; letter-spacing: 0.5px; }
        .meta-info { text-align: right; vertical-align: bottom; color: #4a5568; font-size: 9px; line-height: 1.5; }

        /* Compact Grid Layout Data Table Styles */
        .report-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .report-table th { background-color: #1a365d; color: #ffffff; text-align: left; padding: 5px 4px; font-weight: bold; text-transform: uppercase; font-size: 9px; border: 1px solid #1a365d; }
        .report-table td { padding: 5px 4px; border: 1px solid #e2e8f0; font-size: 9px; vertical-align: middle; }
        .report-table tr:nth-child(even) { background-color: #f8fafc; }

        /* Status Badges */
        .status-badge { padding: 1px 4px; border-radius: 3px; font-size: 8px; font-weight: bold; text-align: center; display: inline-block; }
        .status-1 { background-color: #c6f6d5; color: #22543d; }
        .status-0 { background-color: #edf2f7; color: #4a5568; }

        /* Dual Signature Executive Layout Panel */
        .signature-container { width: 100%; margin-top: 50px; page-break-inside: avoid; }
        .signature-box { width: 45%; vertical-align: top; text-align: center; }
        .signature-space { width: 10%; }
        .signature-line { border-top: 1px solid #718096; margin-top: 45px; margin-bottom: 5px; }
        .signature-title { font-size: 10px; font-weight: bold; color: #2d3748; }
        .signature-subtitle { font-size: 9px; color: #718096; }

        /* Fixed Footer — DomPDF supports position:fixed for repeating footers */
        .footer { position: fixed; bottom: -10px; left: 0px; right: 0px; height: 20px; text-align: center; font-size: 8px; color: #a0aec0; border-top: 1px solid #e2e8f0; padding-top: 4px; }
    </style>
</head>
<body>

    <!-- 1. Executive Corporate Header -->
    <table class="company-header">
        <tr>
            <td class="logo-box">
                @if ($metaData['logo'])
                    {{-- Real logo, embedded as base64 — DomPDF needs a data URI
                         or an absolute filesystem path, not a public asset() URL --}}
                    <img src="{{ $metaData['logo'] }}" style="width: 120px;">
                @else
                    {{-- Falls back to text if public/images/logo.png doesn't exist --}}
                    <div class="logo-placeholder">JAPAN GCC</div>
                @endif
            </td>
            <td class="address-box">
                <strong>Japan GCC Motor Registry Ltd.</strong><br>
                12-4 Corporate Boulevard, Chiyoda City, Tokyo, Japan<br>
                Phone: +81 3-5555-0199 | Email: registry@japan-gcc.com<br>
                Web: https://japan-gcc.com
            </td>
        </tr>
    </table>

    <!-- Meta Details Tracking Metadata Section -->
    <table style="width: 100%; margin-bottom: 5px;">
        <tr>
            <td style="width: 60%;"><div class="report-title">Official Inventory & Specifications Report</div></td>
            <td class="meta-info" style="width: 40%;">
                <strong>Generated:</strong> {{ $metaData['generated'] }}<br>
                <strong>Total Records:</strong> {{ $metaData['total_rows'] }}<br>
                @if ($metaData['range'])
                    <strong>Filter Period:</strong> {{ $metaData['range'] }}
                @else
                    <strong>Filter Period:</strong> All records
                @endif
            </td>
        </tr>
    </table>

    <!-- 2. Main Product Grid Rendering Engine -->
    <table class="report-table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Name</th>
                <th>Price (¥)</th>
                <th>Chassis #</th>
                <th>Engine #</th>
                <th>Year</th>
                <th>Score</th>
                <th>Grade</th>
                <th>CC</th>
                <th>Color</th>
                <th>WD</th>
                <th>Trans</th>
                <th>Odo</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td><strong>{{ $product->product_code }}</strong></td>
                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                    <td>{{ $product->brand->name ?? 'N/A' }}</td>
                    <td>{{ Str::limit($product->name, 15) }}</td>
                    <td>{{ number_format($product->price) }}</td>
                    <td>{{ $product->ChassisNumber ?? '-' }}</td>
                    <td>{{ $product->EngineNumber ?? '-' }}</td>
                    <td>{{ $product->Year ?? '-' }}</td>
                    <td>{{ $product->Score ?? '-' }}</td>
                    <td>{{ $product->AuctionGrade ?? '-' }}</td>
                    <td>{{ $product->CC ?? '-' }}</td>
                    <td>{{ $product->Color ?? '-' }}</td>
                    <td>{{ $product->WD ?? '-' }}</td>
                    <td>{{ $product->Transmission ?? '-' }}</td>
                    <td>{{ number_format($product->ODOMeter) }}</td>
                    <td>
                        <span class="status-badge status-{{ $product->Status }}">
                            {{ $product->Status == 1 ? 'Actual' : 'General' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- 3. Professional Double Verification Signature Blocks -->
    <table class="signature-container">
        <tr>
            <td class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-title">Prepared By Registry Officer</div>
                <div class="signature-subtitle">Operations & Logistics Dept.</div>
            </td>
            <td class="signature-space"></td>
            <td class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-title">Authorized Executive Endorsement</div>
                <div class="signature-subtitle">Japan GCC Corporate Signatory</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        This document is an official inventory record statement generated by Japan GCC Registry Engine. All data valid at time of print execution.
    </div>

</body>
</html>