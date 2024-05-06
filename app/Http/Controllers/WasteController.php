<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use App\Models\Unit;
use App\Models\WasteItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class WasteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $wastes = WasteItem::search($request->search_query)->latest()->paginate(10);
        return view("inventory.waste.index", [
            'wastes' => $wastes
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
        $masterItems = MasterItem::latest()->get();
        return view("inventory.waste.create", [
            'masterItems' => $masterItems,
            'units' => $units,
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
            'item' => ['required', 'string'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'unit' => ['required', 'string'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $masterItem = MasterItem::where('id',  $request->item)->first();

        if (!$masterItem) {
            return Redirect::back()->with("error", "Inventory item was not found.");
        }

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

        $masterItem->in_stock -= $quantity;
        $masterItem->save();


        $wasteItem = new WasteItem();
        $wasteItem->master_item_id = $request->item;
        $wasteItem->master_item_name = MasterItem::where('id',  $request->item)->first()->name;
        $wasteItem->quantity = $quantity;
        $wasteItem->unit = $unit;
        $wasteItem->notes = $request->notes;
        $wasteItem->save();

        return Redirect::back()->with("success", "Waste has been updated.");
    }


    public function destroy(WasteItem $waste)
    {

        $masterItem = MasterItem::where("id", $waste->master_item_id)->first();
        if ($masterItem) {
            $masterItem->in_stock += $waste->quantity;
            $masterItem->save();
        }else{
            return Redirect::back()->with("error", "Inventory item was not found.");
        }
        $waste->delete();
        return Redirect::back()->with("success", "Waste has been update.");
    }
}

