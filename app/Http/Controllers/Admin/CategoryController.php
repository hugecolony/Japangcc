<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFormRequest;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {

     $query  = Category::query();
        if($search = request('search')){
            $query->where('name','LIKE',"%{$search}%");
        }

        $categories = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('admin.category.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    // public function scopeActive(Builder $query): Builder
    // {
    //     // Adjust 'status' and 1 to match your database column and value
    //     return $query->where('status', 1);
    // }

    public function store(CategoryFormRequest $request)
    {
        // code...
        $validatedData = $request->validated();
        $category = new Category;
        $category->name = $validatedData['name'];
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.category.edit', compact('category'));
    }

    public function update(CategoryFormRequest $request, $id)
    {
        $validatedData = $request->validated();
        $category = Category::findOrFail($id);
        $category->name = $validatedData['name'];
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

   public function destroy(Category $id)
{
// Check if category has related brands OR related products
    // $hasBrands = $category->brands()->exists();
    // $hasProducts = $category->products()->exists();

    // if ($hasBrands || $hasProducts) {
    //     // Construct a descriptive error message based on what exists
    //     if ($hasBrands && $hasProducts) {
    //         $errorMessage = 'Cannot delete category: It still has associated brands and products.';
    //     } elseif ($hasBrands) {
    //         $errorMessage = 'Cannot delete category: It still has associated brands.';
    //     } else {
    //         $errorMessage = 'Cannot delete category: It still has associated products.';
    //     }

    //     return redirect()->route('admin.categories.index')
    //         ->with('error', $errorMessage);
//    }
if ($id->products()->exists() || $id->brands()->exists()) {
                        $errorMessage = 'Cannot delete product: It still has associated brands and products.';

            return redirect()->route('admin.categories.index')
            ->with('error', $errorMessage);          
              
            }
    // Delete the category if no products or brands are linked
    $id->delete();

    // Fixed route name to maintain consistency (admin.categories.index)
    return redirect()->route('admin.categories.index')
        ->with('success', 'Category deleted successfully.');

}
}
