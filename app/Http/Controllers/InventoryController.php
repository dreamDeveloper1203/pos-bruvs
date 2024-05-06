<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResourceCollection;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class InventoryController extends Controller
{
    /**
     * Show resources.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories(): JsonResponse
    {
        return $this->jsonResponse(["data" => new CategoryResourceCollection(
            Cache::rememberForever(Category::CACHE_KEY, function () {
                return Category::with(['products' =>  function ($query) {
                    $query->active()->latest();
                }])->active()->orderBy("sort_order", "ASC")->latest()->get();
            })
        )]);
    }
}
