<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\Availability;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CategoryController extends Controller
{

    use Availability;
    /**
     * Show resources.
     * 
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $categories = Category::search($request->search_query)->latest()->paginate(10);

        return view("categories.index", [
            'categories' => $categories
        ]);
    }


    /**
     * Show resources.
     * 
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view("categories.create");
    }
    /**
     * Show resources.
     * 
     * @return \Illuminate\View\View
     */
    public function edit(Category $category): View
    {
        return view("categories.edit", [
            'category' => $category
        ]);
    }
    /**
     * Delete resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->deleteImage();
        $category->delete();
        Cache::forget(Category::CACHE_KEY);
        return Redirect::back()->with("success", Lang::get("messages.category_delete"));
    }
    /**
     * Delete resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function imageDestroy(Category $category): RedirectResponse
    {
        $category->deleteImage();
        Cache::forget(Category::CACHE_KEY);
        return Redirect::back()->with("success", Lang::get("messages.category_image_delete"));
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
            'sort_order' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2024'],
            'status' => ['required', 'string'],
        ]);

        $category = Category::create([
            'name' => $request->name,
            'sort_order' => $request->sort_order,
            'is_active' => $this->isAvailable($request->status),
        ]);

        if ($request->has('image')) {
            $category->updateImage($request->image);
        }
        Cache::forget(Category::CACHE_KEY);
        return Redirect::back()->with("success", Lang::get("messages.category_create"));
    }

    /**
     * update resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'sort_order' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2024'],
            'status' => ['required', 'string'],
        ]);

        $category->update([
            'name' => $request->name,
            'sort_order' => $request->sort_order,
            'is_active' => $this->isAvailable($request->status),
        ]);
        if ($request->has('image')) {
            $category->updateImage($request->image);
        }
        Cache::forget(Category::CACHE_KEY);
        return Redirect::back()->with("success", Lang::get("messages.category_create"));
    }
}
