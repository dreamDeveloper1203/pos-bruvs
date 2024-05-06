<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MasterItemResourceCollection;
use App\Models\MasterItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MasterItemController extends Controller
{
    /**
     * Show resources.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->access_token != '$2a$12$ouKUJlDrvBJDYAmUgpxFK.JcyXLj4Tq9Y1xPtX.nOm.I./Xyt.aOq') {
            abort(Response::HTTP_UNAUTHORIZED);
        }
        return $this->jsonResponse(["data" => new MasterItemResourceCollection(MasterItem::orderBy('name', 'ASC')->get())]);
    }
}
