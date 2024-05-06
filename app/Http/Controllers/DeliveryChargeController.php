<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DeliveryChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function show(Request $request): View
    {
        $from = is_null($request->from) ? "2022-05-01" : $request->from;
        $to = is_null($request->to) ? Carbon::tomorrow()->toDateString() : $request->to;

        $collection = Order::select(
            DB::raw('DATE_FORMAT(created_at, "%d %M %Y") as date'),
            DB::raw('SUM(delivery_charge) as total'),
            DB::raw('max(created_at) as createdAt')
        )->groupBy('date')->orderBy(DB::raw("createdAt"), 'DESC')
            ->whereBetween('created_at', [$from, $to])
            ->paginate(10);

        return view('delivery-charge.show', [
            'collection' => $collection
        ]);
    }
}
