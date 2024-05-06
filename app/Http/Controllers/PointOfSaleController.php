<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PointOfSaleController extends Controller
{
    /**
     * Show resources.
     * 
     * @return \Illuminate\View\View
     */
    public function show(): View
    {


        return view("pos.show", [
            'taxRate' => Settings::defaultTaxRateValue(),
            'deliveryCharge' => Settings::defaultDeliveryChargeValue(),
            'discount' => Settings::defaultDiscountValue(),
        ]);
    }
}
