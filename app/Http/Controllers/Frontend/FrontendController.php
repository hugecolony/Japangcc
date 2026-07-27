<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\HtmlBuilder;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->startDate ?? null;
            $endDate   = $request->endDate ?? null;

            $users = Product::query()->with('brand', 'category');

            if ($startDate && $endDate) {
                $start = Carbon::parse($startDate)->startOfDay();
                $end   = Carbon::parse($endDate)->endOfDay();

                $users->whereBetween('created_at', [$start, $end]);
            }

            return DataTables::eloquent($users)
                ->addIndexColumn()
                ->addColumn('created_at', function ($user) {
                    return $user->created_at ? $user->created_at->format('Y-m-d') : '';
                })
                ->filterColumn('brand.name', function ($query, $keyword) {
                    $query->whereHas('brand', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('category.name', function ($query, $keyword) {
                    $query->whereHas('category', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                // FIXED: was two separate addColumn('action', ...) calls before —
                // the second silently overwrote the first, so the Invoice button
                // never actually rendered. Merged into a single column.
                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex gap-1 justify-content-center">
                            <button type="button" data-id="' . $row->id . '" class="btn btn-sm btn-primary py-1 px-2 btn-print-invoice" style="font-size:11px;">
                                <i class="fa-solid fa-file-invoice me-1"></i> Invoice
                            </button>
                            <a href="' . route('admin.products.edit', $row->id) . '" class="btn btn-success btn-sm">Edit</a>
                            <button data-id="' . $row->id . '" class="btn btn-danger btn-sm delete-user">Delete</button>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('frontend.index');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['status' => 'success', 'message' => 'Product Deleted Successfully']);
    }

    /**
     * Single-product invoice PDF (unchanged from your version — this one
     * was already working correctly).
     */
    public function printInvoice($id)
    {
        $product = Product::with(['brand', 'category'])->findOrFail($id);

        $invoiceMeta = [
            'invoice_number' => 'INV-' . str_pad($product->id, 6, '0', STR_PAD_LEFT),
            'date'           => now()->format('Y-m-d'),
            'due_date'       => now()->addDays(7)->format('Y-m-d'),
        ];

        $pdf = Pdf::loadView('frontend.generate-pdf', compact('product', 'invoiceMeta'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download($invoiceMeta['invoice_number'] . '.pdf');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    /**
     * The ONE PDF report export method — replaces your old generatePdf()
     * and exportPdf(). Respects the same startDate/endDate filter as the
     * DataTable, and feeds your existing well-built frontendpdf.blade.php
     * template with real logo, company info, and date-range metadata.
     */
    public function exportPdf(Request $request)
    {
        $query = Product::with(['brand', 'category']);

        $startDate = $request->startDate ?? null;
        $endDate   = $request->endDate ?? null;

        $range = null;

        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end   = Carbon::parse($endDate)->endOfDay();

            $query->whereBetween('created_at', [$start, $end]);

            $range = $start->format('Y-m-d') . ' to ' . $end->format('Y-m-d');
        }

        $products = $query->latest()->get();

        // Convert logo to base64 so DomPDF can embed it directly — DomPDF
        // (unlike the browser) can't reliably fetch external/asset() URLs,
        // so the safest approach is inlining it as a data URI, same as the
        // pdfMake logo setup from earlier.
        $logoPath = public_path('images/logo.png');
        $logoBase64 = null;

        if (file_exists($logoPath)) {
            $type = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($logoPath));
        }

        $metaData = [
            'title'      => 'JAPAN GCC - OFFICIAL PRODUCT REGISTRY',
            'generated'  => now()->format('Y-m-d H:i:s'),
            'total_rows' => $products->count(),
            'range'      => $range,
            'logo'       => $logoBase64,
        ];

        $pdf = Pdf::loadView('frontend.frontendpdf', compact('products', 'metaData'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('product_report_' . now()->format('Ymd_His') . '.pdf');
    }
}