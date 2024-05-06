<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\SoldItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        $sales = OrderDetail::select(
            DB::raw('DATE_FORMAT(created_at, "%d %M %Y") as date'),
            DB::raw('sum(total) as total'),
            DB::raw('sum(total_cost) as total_cost'),
            DB::raw('sum(quantity) as total_sold'),
            DB::raw('max(created_at) as createdAt'),
            DB::raw('min(created_at) as createdAtt'),
        )->groupBy('date')->orderBy(DB::raw("createdAt"), 'DESC')->paginate(10);

        return view("sales.index", [
            'sales' => $sales
        ]);
    }



    public function show(string $date)
    {
        $_date = explode(' ', $date)[0];
        $orderDate = explode(' ', $date)[0] . ' 00:00:00';
        $year = Carbon::parse($orderDate)->year;
        $month = Carbon::parse($orderDate)->month;
        $day = Carbon::parse($orderDate)->day;
        
        $sales = OrderDetail::select(
            DB::raw('product_name'),
            DB::raw('SUM(quantity) as qty'),
            DB::raw('product_image_url as image_url'),
            DB::raw('total'),
            DB::raw('total_cost'),
        )->whereHas('order', function ($q) use ($year, $month, $day) {
            $q->whereYear('created_at', '=', $year)
                ->whereMonth('created_at', '=', $month)
                ->whereDay('created_at', '=', $day);
        })->groupBy('product_name')
            ->orderBy('qty', 'DESC')
            ->get();
            
        $soldIngredients = SoldItem::select(
                DB::raw('master_item_id'),
                DB::raw('master_item_name'),
                DB::raw('unit'),
                DB::raw('SUM(quantity) as qty'),
            )->groupBy('master_item_id')->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->whereDay('created_at', '=', $day)->get();

        return view("sales.show", [
            'sales' => $sales,
            'soldIngredients' => $soldIngredients,
            'date' => Carbon::parse($_date)->format('d/m/Y')
        ]);
    }
}
