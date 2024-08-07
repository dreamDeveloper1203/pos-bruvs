<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MasterItem;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Settings;
use App\Models\SoldItem;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class OrderController extends Controller
{

    public function index(Request $request): View
    {
        $orders = Order::with('customer', 'order_details')->search(trim($request->search_query))->latest()->paginate(10);

        $totalCost = OrderDetail::sum('total_cost');
        $totalSold = OrderDetail::sum('total');
        $totalProfile = $totalSold - $totalCost;

        $todayQuery = OrderDetail::whereDate('created_at', Carbon::today());
        $totalOrdersToday = Order::whereDate('created_at', Carbon::today())->count();
        $totalCostToday = $todayQuery->sum('total_cost');
        $totalSoldToday = $todayQuery->sum('total');
        $totalProfileToday = $totalSoldToday - $totalCostToday;


        $thisMonthQuery = OrderDetail::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
        $totalOrdersThisMonth =  Order::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();


        $totalCostThisMonth = $thisMonthQuery->sum('total_cost');
        $totalSoldThisMonth = $thisMonthQuery->sum('total');
        $totalProfileThisMonth = $totalSoldThisMonth - $totalCostThisMonth;

        $thisYearQuery = OrderDetail::whereYear('created_at', date('Y'));
        $totalOrdersThisYear =  Order::whereYear('created_at', date('Y'))->count();


        $totalCostThisYear = $thisYearQuery->sum('total_cost');
        $totalSoldThisYear = $thisYearQuery->sum('total');
        $totalProfileThisYear = $totalSoldThisYear - $totalCostThisYear;

        return view('orders.index', [
            'password' => Settings::routePassword(), //Hash::make(Settings::routePassword()),

            'orders' => $orders,

            'totalOrders' => $orders->total(),
            'totalCost' => currency_format($totalCost),
            'totalSold' => currency_format($totalSold),
            'totalProfile' => currency_format($totalProfile),

            'totalOrdersToday' => $totalOrdersToday,
            'totalCostToday' => currency_format($totalCostToday),
            'totalSoldToday' => currency_format($totalSoldToday),
            'totalProfileToday' => currency_format($totalProfileToday),


            'totalOrdersThisMonth' => $totalOrdersThisMonth,
            'totalCostThisMonth' => currency_format($totalCostThisMonth),
            'totalSoldThisMonth' => currency_format($totalSoldThisMonth),
            'totalProfileThisMonth' => currency_format($totalProfileThisMonth),

            'totalOrdersThisYear' => $totalOrdersThisYear,
            'totalCostThisYear' => currency_format($totalCostThisYear),
            'totalSoldThisYear' => currency_format($totalSoldThisYear),
            'totalProfileThisYear' => currency_format($totalProfileThisYear),
        ]);
    }

    public function deleted(Request $request): View
    {
        $orders = Order::with('customer', 'order_details')
            ->onlyTrashed()->search(trim($request->search_query))->latest()->paginate(10);

        $totalCost = OrderDetail::onlyTrashed()->sum('total_cost');
        $totalSold = OrderDetail::onlyTrashed()->sum('total');
        $totalProfile = $totalSold - $totalCost;

        $todayQuery = OrderDetail::onlyTrashed()->whereDate('created_at', Carbon::today());
        $totalOrdersToday = Order::onlyTrashed()->whereDate('created_at', Carbon::today())->count();
        $totalCostToday = $todayQuery->sum('total_cost');
        $totalSoldToday = $todayQuery->sum('total');
        $totalProfileToday = $totalSoldToday - $totalCostToday;


        $thisMonthQuery = OrderDetail::onlyTrashed()->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
        $totalOrdersThisMonth =  Order::onlyTrashed()->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();


        $totalCostThisMonth = $thisMonthQuery->sum('total_cost');
        $totalSoldThisMonth = $thisMonthQuery->sum('total');
        $totalProfileThisMonth = $totalSoldThisMonth - $totalCostThisMonth;

        $thisYearQuery = OrderDetail::onlyTrashed()->whereYear('created_at', date('Y'));
        $totalOrdersThisYear =  Order::onlyTrashed()->whereYear('created_at', date('Y'))->count();


        $totalCostThisYear = $thisYearQuery->sum('total_cost');
        $totalSoldThisYear = $thisYearQuery->sum('total');
        $totalProfileThisYear = $totalSoldThisYear - $totalCostThisYear;

        return view('orders.deleted', [
            'password' => Settings::routePassword(), //Hash::make(Settings::routePassword()),

            'orders' => $orders,

            'totalOrders' => $orders->total(),
            'totalCost' => currency_format($totalCost),
            'totalSold' => currency_format($totalSold),
            'totalProfile' => currency_format($totalProfile),

            'totalOrdersToday' => $totalOrdersToday,
            'totalCostToday' => currency_format($totalCostToday),
            'totalSoldToday' => currency_format($totalSoldToday),
            'totalProfileToday' => currency_format($totalProfileToday),


            'totalOrdersThisMonth' => $totalOrdersThisMonth,
            'totalCostThisMonth' => currency_format($totalCostThisMonth),
            'totalSoldThisMonth' => currency_format($totalSoldThisMonth),
            'totalProfileThisMonth' => currency_format($totalProfileThisMonth),

            'totalOrdersThisYear' => $totalOrdersThisYear,
            'totalCostThisYear' => currency_format($totalCostThisYear),
            'totalSoldThisYear' => currency_format($totalSoldThisYear),
            'totalProfileThisYear' => currency_format($totalProfileThisYear),
        ]);
    }

    public function show(string $id): View
    {
        $order = Order::withTrashed()->with('customer', 'order_details')->findOrFail($id);

        return view('orders.show', [
            'order' => $order
        ]);
    }

    public function deletedShow(string $id): View
    {
        $order = Order::withTrashed()->with('customer', 'order_details')->findOrFail($id);

        return view('orders.deleted_show', [
            'order' => $order
        ]);
    }

    public function edit(string $id): View
    {
        $order = Order::with('customer', 'order_details')->findOrFail($id);

        return view('orders.edit', [
            'order' => $order
        ]);
    }

    public function print(string $id): View
    {
        $order = Order::with('customer', 'order_details')->findOrFail($id);

        return view('orders.print', [
            'order' => $order
        ]);
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->order_details()->delete();
        $order->delete();
        return Redirect::back()->with("success", "Order has been deleted.");
    }

    public function showAnalytics(): View
    {

        $totalPerMonth = OrderDetail::select(
            DB::raw('DATE_FORMAT(created_at, "%M %Y") as date'),
            DB::raw('SUM(total) as total'),
            DB::raw('max(created_at) as createdAt')
        )->groupBy('date')
            ->orderBy(DB::raw("createdAt"), 'ASC')->take(12)->get()->each(function ($order) {
                $order->setAppends(['display_total']);
            });



        $totalOrdersPerMonth = Order::select(
            DB::raw('DATE_FORMAT(created_at, "%M %Y") as date'),
            DB::raw('count(*) as total'),
            DB::raw('max(created_at) as createdAt')
        )->groupBy('date')
            ->orderBy(DB::raw("createdAt"), 'ASC')->take(12)->get()->each(function ($order) {
                $order->setAppends([]);
            });

        $totalProfitMonth = OrderDetail::select(
            DB::raw('DATE_FORMAT(created_at, "%M %Y") as date'),
            DB::raw('SUM(total) - SUM(total_cost) as total'),
            DB::raw('max(created_at) as createdAt')
        )->groupBy('date')
            ->orderBy(DB::raw("createdAt"), 'ASC')->take(12)->get()->each(function ($order) {
                $order->setAppends([]);
            });
        $totalCostMonth = OrderDetail::select(
            DB::raw('DATE_FORMAT(created_at, "%M %Y") as date'),
            DB::raw('SUM(total_cost) as total'),
            DB::raw('max(created_at) as createdAt')
        )->groupBy('date')
            ->orderBy(DB::raw("createdAt"), 'ASC')->take(12)->get()->each(function ($order) {
                $order->setAppends([]);
            });
        return view('orders.analytics.show', [
            'totalPerMonth' => $totalPerMonth,
            'totalOrdersPerMonth' => $totalOrdersPerMonth,
            'totalProfitMonth' => $totalProfitMonth,
            'totalCostMonth' => $totalCostMonth,
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'subtotal' => ['required', 'numeric'],
            'delivery_charge' => ['required', 'numeric'],
            'discount' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
            'tender_amount' => ['required', 'numeric'],
            'change' => ['required', 'numeric'],
            'tax_rate' => ['required', 'numeric', 'between:0,100'],
            'remarks' => ['nullable', 'string', 'max:3000'],
        ]);

        $cart = (object) $request->cart;
        $order->subtotal = $request->subtotal;
        $order->delivery_charge = $request->delivery_charge;
        $order->discount = $request->discount;
        $order->total = $request->total;
        $order->tender_amount = $request->tender_amount;
        $order->change = $request->change;
        $order->tax_rate = $request->tax_rate;
        $order->remarks = $request->remarks;

        if ($request->has('customer')) {
            $customer = (object) $request->customer;
            $order->customer_id = $customer->id;
        } else {
            $order->customer_id = null;
        }

        if ($request->has('table')) {
            $table = (object) $request->table;
            $order->table_name = $table->name;
            $order->table_status = "pending";
        } else {
            $order->table_name = null;
            $order->table_status = null;
        }

        $order->eat_status = $request->eat_status;
        $order->paid_status = $request->paid_status;

        $order->save();
        $order->order_details()->delete();

        $soldItems = SoldItem::where('order_id', $order->id)->get();

        foreach ($soldItems as $soldItem) {
            $masterItem = MasterItem::where("id", $soldItem->master_item_id)->first();
            $masterItem->in_stock += $soldItem->quantity;
            $masterItem->save();
            $soldItem->delete();
        }

        foreach ($cart as $cartItem) {
            $product = (object)$cartItem;
            $quantity = $product->quantity > 0 ? $product->quantity : 0; //prevent vegetive numbers
            $order_detail = new OrderDetail();
            $order_detail->quantity =  $quantity;
            $order_detail->product_name = $product->name;
            $order_detail->product_image_url = $product->image_url;
            $order_detail->price = $product->price;
            $order_detail->cost = $product->cost;
            $order_detail->total = $quantity * $product->price;
            $order_detail->total_cost = $quantity * $product->cost;
            $order_detail->created_at = $order->created_at;
            //$order_detail->product()->associate($product);
            $order_detail->order()->associate($order);
            $order_detail->save();
            if ($product->ingredients) {
                foreach ($product->ingredients as $ingredient) {
                    $ingredientObj = (object)$ingredient;
                    $masterItem = MasterItem::where("id", $ingredientObj->master_item_id)->first();
                    if ($masterItem) {
                        $quantitySold = $ingredientObj->quantity * $quantity;
                        $masterItem->in_stock -= $quantitySold;
                        $masterItem->save();

                        $soldItem = new SoldItem();
                        $soldItem->order_id = $order->id;
                        $soldItem->master_item_id = $masterItem->id;
                        $soldItem->master_item_name = $masterItem->name;
                        $soldItem->unit = $masterItem->unit;
                        $soldItem->quantity = $quantitySold;
                        $soldItem->created_at = $order->created_at;
                        $soldItem->save();
                    }
                }
            }
        }
        return $this->jsonResponse();
    }



    public function store(Request $request)
    {

        $request->validate([
            'subtotal' => ['required', 'numeric'],
            'delivery_charge' => ['required', 'numeric'],
            'discount' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
            'tender_amount' => ['required', 'numeric'],
            'change' => ['required', 'numeric'],
            'tax_rate' => ['required', 'numeric', 'between:0,100'],
            'remarks' => ['nullable', 'string', 'max:3000'],
        ]);



        $cart = (object) $request->cart;


        $order = new Order();
        $order->number = date("ynjhsi");

        $order->subtotal = $request->subtotal;
        $order->delivery_charge = $request->delivery_charge;
        $order->discount = $request->discount;
        $order->total = $request->total;
        $order->tender_amount = $request->tender_amount;
        $order->change = $request->change;
        $order->tax_rate = $request->tax_rate;
        $order->remarks = $request->remarks;

        if ($request->has('customer')) {
            $customer = (object) $request->customer;
            $order->customer_id = $customer->id;
        }
        if ($request->has('table')) {
            $table = (object) $request->table;
            $order->table_name = $table->name;
            $order->table_status = "pending";
        }
        $order->user_id = $request->user()->id;

        $order->eat_status = $request->eat_status;
        $order->paid_status = $request->paid_status;

        $order->save();

        foreach ($cart as $cartItem) {
            $product = (object)$cartItem;
            $quantity = $product->quantity > 0 ? $product->quantity : 0; //prevent vegetive numbers
            $order_detail = new OrderDetail();
            $order_detail->quantity =  $quantity;
            $order_detail->product_name = $product->name;
            $order_detail->product_image_url = $product->image_url;
            $order_detail->price = $product->price;
            $order_detail->cost = $product->cost;
            $order_detail->total = $quantity * $product->price;
            $order_detail->total_cost = $quantity * $product->cost;
            $order_detail->created_at = $order->created_at;
            //$order_detail->product()->associate($product);
            $order_detail->order()->associate($order);
            $order_detail->save();

            if ($product->ingredients) {
                foreach ($product->ingredients as $ingredient) {
                    $ingredientObj = (object)$ingredient;
                    $masterItem = MasterItem::where("id", $ingredientObj->master_item_id)->first();
                    if ($masterItem) {
                        $quantitySold = $ingredientObj->quantity * $quantity;
                        $masterItem->in_stock -= $quantitySold;
                        $masterItem->save();

                        $soldItem = new SoldItem();
                        $soldItem->order_id = $order->id;
                        $soldItem->master_item_id = $masterItem->id;
                        $soldItem->master_item_name = $masterItem->name;
                        $soldItem->unit = $masterItem->unit;
                        $soldItem->quantity = $quantitySold;
                        $soldItem->created_at = $order->created_at;
                        $soldItem->save();
                    }
                }
            }
        }

        // if (Settings::sendCustomerEmail()) {
        //     if ($request->has('customer')) {
        //         $customer = (object) $request->customer;
        //         if ($customer->email) {
        //             //send email
        //         }
        //     }
        // }


        return $this->jsonResponse([
            'order_number' => $order->number,
            'date_view' => $order->date_view,
            'time_view' => $order->time_view,
        ]);
    }



    public function filter(Request $request): View
    {
        $from = is_null($request->from) ? now()->toDateString() : $request->from;
        $to = is_null($request->to) ? now()->toDateString() : $request->to;

        $customerName = $request->name;
        if (!is_null($customerName)) {
            $customer = Customer::search($customerName)->first();
            $orders = $customer->orders()->latest()->whereBetween('created_at', [$from, $to])->paginate(10);
            $totalCost =  $customer->order_details->whereBetween('created_at', [$from, $to])->sum('total_cost');
            $totalSold =  $customer->order_details->whereBetween('created_at', [$from, $to])->sum('total');


            $totalPerMonth = $customer->orders()->select(
                DB::raw('DATE_FORMAT(created_at, "%M %Y") as date'),
                DB::raw('SUM(total) as total'),
                DB::raw('max(created_at) as createdAt')
            )->groupBy('date')->orderBy(DB::raw("createdAt"), 'ASC')->whereBetween('created_at', [$from, $to])
                ->get()->each(function ($order) {
                    $order->setAppends([]);
                });

            $totalOrdersPerMonth = $customer->orders()->select(
                DB::raw('DATE_FORMAT(created_at, "%M %Y") as date'),
                DB::raw('count(*) as total'),
                DB::raw('max(created_at) as createdAt')
            )->groupBy('date')
                ->orderBy(DB::raw("createdAt"), 'ASC')->whereBetween('created_at', [$from, $to])->get()->each(function ($order) {
                    $order->setAppends([]);
                });
        } else {
            $orders = Order::latest()->whereBetween('created_at', [$from, $to])->paginate(10);
            $totalCost =  OrderDetail::whereBetween('created_at', [$from, $to])->sum('total_cost');
            $totalSold =  OrderDetail::whereBetween('created_at', [$from, $to])->sum('total');

            $totalPerMonth = Order::select(
                DB::raw('DATE_FORMAT(created_at, "%M %Y") as date'),
                DB::raw('SUM(total) as total'),
                DB::raw('max(created_at) as createdAt')
            )->groupBy('date')
                ->orderBy(DB::raw("createdAt"), 'ASC')->whereBetween('created_at', [$from, $to])->get()->each(function ($order) {
                    $order->setAppends(['display_total']);
                });

            $totalOrdersPerMonth = Order::select(
                DB::raw('DATE_FORMAT(created_at, "%M %Y") as date'),
                DB::raw('count(*) as total'),
                DB::raw('max(created_at) as createdAt')
            )->groupBy('date')
                ->orderBy(DB::raw("createdAt"), 'ASC')->whereBetween('created_at', [$from, $to])->get()->each(function ($order) {
                    $order->setAppends([]);
                });
        }
        $totalProfile = $totalSold - $totalCost;

        return view('orders.filter', [
            'orders' => $orders,
            'totalOrders' => $orders->total(),
            'totalCost' => currency_format($totalCost),
            'totalSold' => currency_format($totalSold),
            'totalProfile' => currency_format($totalProfile),

            'totalPerMonth' => $totalPerMonth,
            'totalOrdersPerMonth' => $totalOrdersPerMonth,
        ]);
    }


    public function updateOrderTableStatusToCheckOut(Order $order)
    {
        if ($order->has_table) {
            $order->table_status = "checked out";
            $order->save();
        }
        return Redirect::back()->with("success", "Table has been set as Checked Out.");
    }
    public function updateOrderTableStatusToPending(Order $order)
    {
        if ($order->has_table) {
            $order->table_status = "pending";
            $order->save();
        }
        return Redirect::back()->with("success", "Table has been set as Pending.");
    }
}
