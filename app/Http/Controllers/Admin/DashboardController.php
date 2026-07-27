<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
            $products = Product::all();      
        //$products = $query->orderBy('id','DESC')->paginate(10)->withQueryString();
        $categories = Category::select('id','name')->orderBy('name')->get();
        $brands = Brand::select('id','name')->orderBy('name')->get();

        return view('admin.dashboard', compact('products', 'categories', 'brands'));
    }
}
