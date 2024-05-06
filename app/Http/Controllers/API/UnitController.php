<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnitController extends Controller
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
        return $this->jsonResponse(["data" => Unit::getUnits()]);
    }
}
