<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandFormRequest;
use App\Models\Brand;
use App\Models\Category;
use Yajra\DataTables\Html\HtmlBuilder;

class BrandController extends Controller
{
    public function index()
    {
        $query  = Brand::query();
        if($search = request('search')){
            $query->where('name','LIKE',"%{$search}%");
        }
        
        //$brands = Brand::orderBy('id', 'desc')->paginate(10);
        $brands = $query->orderBy('id','DESC')->paginate(10)->withQueryString();
        return view('admin.brand.index', ['brands' => $brands]);
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.brand.create', compact('categories'));
    }

    public function store(BrandFormRequest $request)
    {
        // code...
        $validatedData = $request->validated();

        $Brand = new Brand;
        $Brand->name = $validatedData['name'];
        $Brand->category_id = $validatedData['category_id'];
        $Brand->save();

        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully.');
    }

    // public function scopeActive(Builder $query): Builder
    // {
    //     // Adjust 'status' and 1 to match your database column and value
    //     return $query->where('status', 1);
    // }

    public function edit($id)
    {
        $Brand = Brand::findOrFail($id);
        $categories = Category::all();

        return view('admin.brand.edit', compact('Brand', 'categories'));
    }

    public function update(BrandFormRequest $request, $id)
    {
        $validatedData = $request->validated();
        $Brand = Brand::findOrFail($id);
        $Brand->name = $validatedData['name'];
        $Brand->category_id = $validatedData['category_id'];
        $oldCode = $Brand->brand_code;
        $message = $Brand->brand_code !== $oldCode
                 ? "Brand updated. Code changed from {$oldCode} to {$Brand->brand_code}."
                 : 'Brand updated successfully.';

        //        dd($Brand->brand_code,$Brand->category_id,$oldCode,$message);
        $Brand->save();

        return redirect()->route('admin.brands.index')->with('success', $message);
    }

    public function destroy(Brand $id)
    {

        if ($id->products()->exists()) {
                        $errorMessage = 'Cannot delete brand: It still has associated brands and products.';

            return redirect()->route('admin.categories.index')
            ->with('error', $errorMessage);        }

        $id->delete();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand deleted successfully.');
    }
}
