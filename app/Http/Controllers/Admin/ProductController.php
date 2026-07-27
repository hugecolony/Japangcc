<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
class ProductController extends Controller
{
    public function index(Request $request)
    {
        //$query = Product::with(['brand.category']);

//        $query = Product::query();
            $query = Product::with('category','brand');      
        // if ($request->filled('search')) {
        //     $search  = $request->input('search');
        //     $query->where(function ($q) use ($search) {
        //         $q->where('name', 'LIKE', "%{$search}%")
        //             ->orWhere('CC', 'like', "%{$search}%");
        //     });
        // }


        if ($request->filled('category')){
            $query->where('category_id',$request->input('category'));
        }
         if ($request->filled('brand')){
            $query->where('brand_id',$request->input('brand'));
        }

        if ($request->filled('category_id')) {
            $query->whereHas('brand', fn ($q) => $q->where('category_id', $request->category_id));
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }


        if($search = request('search')){
            $query->where('name','LIKE',"%{$search}%");
        }
        // if($status= request('status')){
        //     $query->where('status',$status);
        // }

        if(request()->filled('status')){
                $query->where('status',request('status'));
        }
        //$products = $query->latest()->paginate(10)->withQueryString();
        $products = $query->orderBy('id','DESC')->paginate(10)->withQueryString();
        $categories = Category::select('id','name')->orderBy('name')->get();
        $brands = Brand::select('id','name')->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

      
        
    public function create(Request $request)
    {
        $categories = Category::all();
        $selectedCategoryId = $request->query('category_id');

        // Fetch brands only if category_id query param is present
        $brands = $selectedCategoryId
            ? Brand::where('category_id', $selectedCategoryId)->get()
            : collect();

        // ///

        $selectedBrandId = $request->query('brand_id');

        // Fetch brands only if category_id query param is present
        $products = $selectedBrandId
            ? Product::where('brand_id', $selectedBrandId)->get()
            : collect();

        return view('admin.products.create', compact('categories', 'brands', 'selectedCategoryId'));
    }

    public function store(ProductFormRequest $request)
    {
        // code...
        $validatedData = $request->validated();

        // $category = Category::findOrFail($validatedData['category_id']);
        //         $brand = Brand::findOrFail($validatedData['brand_id']);
        //         $category->products()->create([
        //             'category_id'=>$validatedData['category_id'],
        //             'name'=>$validatedData['name']
        //         ]);

        //         return $product->id;
        $products = new Product;
        $products->name = $validatedData['name'];
        $products->category_id = $validatedData['category_id'];
        $products->brand_id = $validatedData['brand_id'];
        $products->ChassisNumber = $validatedData['ChassisNumber'];

        $products->EngineNumber = $validatedData['EngineNumber'];
        $products->Color = $validatedData['Color'];
        $products->Year = $validatedData['Year'];
        $products->price = $validatedData['price'];
        $products->CC = $validatedData['CC'];
        $products->WD = $validatedData['WD'];
        $products->Transmission = $validatedData['Transmission'];

        $products->PickupYard = $validatedData['PickupYard'];
        $products->Supplier = $validatedData['Supplier'];
        $products->ODOMeter = $validatedData['ODOMeter'];
        $products->Score = $validatedData['Score'];
        $products->AuctionGrade = $validatedData['AuctionGrade'];
        $products->InvoiceNumber = $validatedData['InvoiceNumber'];
        $products->Remarks = $validatedData['Remarks'];
        $products->Status = $validatedData['Status'];

        $products->save();

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id, Request $request)
    {
        $products = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::where('category_id', $products->category_id)->get();
        //  $brands = Brand::active()
        //         ->where('category_id', $products->category_id)
        //         ->get();
        $selectedCategoryId = $request->query('category_id');
        // $brands = $selectedCategoryId
        // ? Brand::where('category_id', $products->category_id)->get()
        // : collect();

        // ////

        // $selectedBrandId = $request->query('brand_id');
        $selectedCategoryId = $request->query('category_id', $products->category_id);

        $brands = Brand::where('category_id', $selectedCategoryId)->get();

        return view('admin.products.edit', compact('brands', 'categories', 'products', 'selectedCategoryId'));
    }

    public function update(ProductFormRequest $request, $id)
    {
        $validatedData = $request->validated();
        $product = Product::findOrFail($id);
        $product->name = $validatedData['name'];
        $product->category_id = $validatedData['category_id'];
        $product->ChassisNumber = $validatedData['ChassisNumber'];
        $product->EngineNumber = $validatedData['EngineNumber'];

        // $products->Color = $validatedData['Color'];
        // $products->Year = $validatedData['Year'];
        // $products->price = $validatedData['price'];
        // $products->CC = $validatedData['CC'];
        // $products->WD = $validatedData['WD'];
        // $products->Transmission = $validatedData['Transmission'];

        // $products->PickupYard = $validatedData['PickupYard'];
        // $products->Supplier = $validatedData['Supplier'];
        // $products->ODOMeter = $validatedData['ODOMeter'];
        // $products->Score = $validatedData['Score'];
        // $products->AuctionGrade = $validatedData['AuctionGrade'];
        // $products->InvoiceNumber = $validatedData['InvoiceNumber'];
        // $products->Remarks = $validatedData['Remarks'];
        // $products->Status = $validatedData['Status'];

        //                 $oldCode = $product->brand_code;
        //    $message = $product->product_code !== $oldCode
        //             ? "Product updated. Code changed from {$oldCode} to {$product->product_code}."
        //             : 'Product updated successfully.';

        $oldCode = $product->product_code;

        $product->update($validatedData); // must call ->update() on the model instance

        $message = $product->product_code !== $oldCode
            ? "Product updated. Code changed from {$oldCode} to {$product->product_code}."
            : 'Product updated successfully.';

        //        dd($Brand->brand_code,$Brand->category_id,$oldCode,$message);
        $product->save();

        return redirect()->route('admin.products.index')->with('success', $message);
    }

    public function destroy(Product $id)
    {

        $id->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Products deleted successfully.');
    }

    public function productBulkDelete(Request $request){
        $request->validate([
           'ids'=> 'required:array',
           'ids.*'=>'exists:products,id'  
        ]);
        $ids = $request->ids;
        $products = Product::whereIn('id',$ids)->get();
        foreach($products as $product){
                $product->delete();
        }
        
        return redirect()->route('admin.products.index')
            ->with('success', count($ids) . 'Products deleted successfully.');





    }


      public function generatePdf(){
            $products = Product::get();
            $users = User::get();
            $data = [
                'title' => 'Japan GCC',
                'date' =>  date('m/d/y'),
                'products' => $products,
                'users' => $users,
            ];
            $pdf = Pdf::loadView('admin.products.generate-product-pdf',$data);
              //$pdf = Pdf::loadView('frontend.frontendpdf',$data);
      
                return $pdf->download('invoice.pdf');

        }
        
}
