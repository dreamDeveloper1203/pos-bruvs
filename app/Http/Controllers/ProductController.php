<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Traits\Availability;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProductController extends Controller
{
    use Availability;
    /**
     * Show resources.
     * 
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $products = Product::search($request->search_query)->with("category")->latest()->paginate(10);

        return view("products.index", [
            'products' => $products
        ]);
    }


    /**
     * Show resources.
     * 
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view("products.create", [
            'categories' => Category::latest()->get(),
        ]);
    }
    /**
     * Show resources.
     * 
     * @return \Illuminate\View\View
     */
    public function edit(Product $product): View
    {
        return view("products.edit", [
            'product' => $product,
            'categories' => Category::latest()->get(),
        ]);
    }
    /**
     * Delete resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->deleteImage();
        $product->delete();
        Cache::forget(Category::CACHE_KEY);
        return Redirect::back()->with("success", Lang::get("messages.product_delete"));
    }
    /**
     * Delete resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function imageDestroy(Product $product): RedirectResponse
    {
        $product->deleteImage();
        Cache::forget(Category::CACHE_KEY);
        return Redirect::back()->with("success", Lang::get("messages.product_image_delete"));
    }

    /**
     * Show resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'sale_price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['required', 'numeric', 'min:0'],
            'cost' => ['required', 'numeric', 'min:0'],
            'sort_order' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2024'],
            'description' => ['nullable', 'string', 'max:2000'],
            'barcode' => ['nullable', 'string', 'max:43'],
            'sku' => ['nullable', 'string', 'max:64'],
            'status' => ['required', 'string'],
            'category' => ['required', 'string'],
        ]);

        $product = Product::create([
            'name' => $request->name,
            'sort_order' => $request->sort_order,
            'is_active' => $this->isAvailable($request->status),
            'sale_price' => $request->sale_price,
            'discount_price' => $request->discount_price,
            'cost' => $request->cost,
            'description' => $request->description,
            'barcode' => $request->barcode,
            'sku' => $request->sku,
            'category_id' => $request->category,
        ]);

        if ($request->has('image')) {
            $product->updateImage($request->image);
        }
        Cache::forget(Category::CACHE_KEY);
        return Redirect::back()->with("success", Lang::get("messages.product_create"));
    }

    /**
     * update resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'sale_price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['required', 'numeric', 'min:0'],
            'cost' => ['required', 'numeric', 'min:0'],
            'sort_order' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2024'],
            'description' => ['nullable', 'string', 'max:2000'],
            'barcode' => ['nullable', 'string', 'max:43'],
            'sku' => ['nullable', 'string', 'max:64'],
            'status' => ['required', 'string'],
            'category' => ['required', 'string'],
        ]);

        $product->update([
            'name' => $request->name,
            'sort_order' => $request->sort_order,
            'is_active' => $this->isAvailable($request->status),
            'sale_price' => $request->sale_price,
            'discount_price' => $request->discount_price,
            'cost' => $request->cost,
            'description' => $request->description,
            'barcode' => $request->barcode,
            'sku' => $request->sku,
            'category_id' => $request->category,
        ]);
        if ($request->has('image')) {
            $product->updateImage($request->image);
        }
        Cache::forget(Category::CACHE_KEY);
        return Redirect::back()->with("success", Lang::get("messages.product_create"));
    }
}
