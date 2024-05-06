<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use Illuminate\Http\Request;

class MasterItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = MasterItem::latest()->paginate(20);
        return view("inventory.master-items.index", [
            'items' => $items
        ]);
    }
}
