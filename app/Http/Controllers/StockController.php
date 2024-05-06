<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use App\Models\Stock;
use App\Models\Unit;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stocks = Stock::search($request->search_query)->with("vendor")->latest()->paginate(10);
        return view("inventory.stocks.index", [
            'stocks' => $stocks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Unit::getUnits();
        $vendors = Vendor::latest()->get();
        $masterItems = MasterItem::latest()->get();
        return view("inventory.stocks.create", [
            'units' => $units,
            'vendors' => $vendors,
            'masterItems' => $masterItems
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'total_price' => ['required', 'numeric', 'min:0'],
            'unit' => ['required', 'string'],
            'vendor' => ['nullable', 'string', 'max:64'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $masterItemName = $request->name;
        $masterItemNameSlug =  Str::slug($masterItemName);
        $requestUnit = $request->unit;
        $requestQuantity = $request->quantity;
        $unit = "";
        $quantity = 0;

        if ($requestUnit == Unit::GRAM) {
            $unit = Unit::KILOGRAM;
            $quantity = $requestQuantity / 1000;
        } elseif ($requestUnit == Unit::MILLILITER) {
            $unit = Unit::LITER;
            $quantity = $requestQuantity / 1000;
        } else {
            $unit = $requestUnit;
            $quantity = $requestQuantity;
        }

        Stock::create([
            'master_item_name' => $masterItemName,
            'quantity' => $quantity,
            'total_price' => $request->total_price,
            'unit' => $unit,
            'vendor_id' => $request->vendor,
            'notes' => $request->notes,
        ]);

        $masterItem = MasterItem::where("slug", $masterItemNameSlug)->first();

        if ($masterItem) {
            $masterItem->in_stock += $quantity;
            $masterItem->unit = $unit;
            $masterItem->save();
        } else {
            $masterItem = new MasterItem();
            $masterItem->name = $masterItemName;
            $masterItem->slug = $masterItemNameSlug;
            $masterItem->in_stock = $quantity;
            $masterItem->unit = $unit;
            $masterItem->save();
        }

        return Redirect::back()->with("success", "Stock has been updated.");
    }


    public function destroy(Stock $stock)
    {

        $masterItem = MasterItem::where("slug", Str::slug($stock->master_item_name))->first();
        if ($masterItem) {
            $masterItem->in_stock -= $stock->quantity;
            $masterItem->save();
        }else{
            return Redirect::back()->with("error", "Error Occurred.");
        }
        $stock->delete();
        return Redirect::back()->with("success", "Stock has been update.");
    }
}
