<?php

namespace App\Http\Controllers;

use App\Models\Products;

use App\Models\Orders;
use App\Models\OrdersDetails;
use Carbon\Carbon;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Laporan Harian
    public function dailyReport(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());

        // Query Orders and filter by order_date and order_status
        // Eager load orderDetails and product

        $orders = OrdersDetails::with('product', 'order')->whereHas('order', function ($q) use ($date) {
            $q->select('order_code')->where('order_date', '>=', $date);
        })->get();
        // return $orders;
        // Calculate the totalAmount and totalTransactions
        $totalAmount = $orders->sum('order_subtotal');
        $totalTransactions = $orders->count();

        return view('report.daily', compact('orders', 'totalAmount', 'totalTransactions', 'date'));
    }

    // Laporan Mingguan
    public function weeklyReport(Request $request)
    {

        $dt['startDate'] = $request->input('start_date', Carbon::now()->startOfWeek());
        $dt['endDate'] = $request->input('end_date', Carbon::now()->endOfWeek());

        $orders = OrdersDetails::with('product', 'order')->whereHas('order', function ($q) use ($dt) {
            $q->where('order_date', '>=', $dt['startDate'])->where('order_date', '>=', $dt['endDate']);
        })->get();

        $totalAmount = $orders->sum('order_subtotal');
        $totalTransactions = $orders->count();

        // Data untuk chart mingguan
        $dailyData = Orders::whereBetween('order_date', [$dt['startDate'], $dt['endDate']])
            ->where('order_status', 1)
            ->selectRaw('DATE(order_date) as date, SUM(order_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('report.weekly', compact('orders', 'totalAmount', 'totalTransactions', 'dt', 'dailyData'));
    }

    public function monthlyReport(Request $request)
    {
        $month = (int) $request->input('month', Carbon::now()->month);
        $year = (int) $request->input('year', Carbon::now()->year);

        // Perbaikan: apply filter sebelum get()
        $orders = Orders::with('ordersDetails') // Gunakan camelCase
            ->whereYear('order_date', $year)
            ->whereMonth('order_date', $month)
            ->where('order_status', 1)
            ->orderBy('order_date', 'desc')
            ->get();
        // return $orders;
        $totalAmount = $orders->sum('order_amount');
        $totalTransactions = $orders->count();

        // Data untuk chart bulanan
        $dailyData = Orders::selectRaw('DAY(order_date) as day, SUM(order_amount) as total')
            ->whereYear('order_date', $year)
            ->whereMonth('order_date', $month)
            ->where('order_status', 1)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return view('report.monthly', compact(
            'orders',
            'totalAmount',
            'totalTransactions',
            'month',
            'year',
            'dailyData'
        ));
    }

    // Laporan Bulanan
    // public function monthlyReport(Request $request)
    // {
    //     $month = $request->input('month', Carbon::now()->month);
    //     $year = $request->input('year', Carbon::now()->year);

    //     $orders = Orders::with('OrdersDetails')->get()
    //         ->whereYear('order_date', $year)
    //         ->whereMonth('order_date', $month)
    //         ->where('order_status', 1)
    //         ->orderBy('order_date', 'desc')
    //         ->get();

    //     $totalAmount = $orders->sum('order_amount');
    //     $totalTransactions = $orders->count();

    //     $dailyData = Orders::whereYear('order_date', $year)->get()
    //         ->whereMonth('order_date', $month)
    //         ->where('order_status', 1)
    //         ->selectRaw('DAY(order_date) as day, SUM(order_amount) as total')
    //         ->groupBy('day')
    //         ->orderBy('day')
    //         ->get();

    //     return view('report.monthly', compact('orders', 'totalAmount', 'totalTransactions', 'month', 'year', 'dailyData'));
    // }

    // Laporan Produk Terlaris
    public function bestSellerReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth());

        $bestSellers = OrdersDetails::with('product')
            ->selectRaw('product_id, SUM(qty) as total_qty, SUM(order_subtotal) as total_amount')
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('order_date', [$startDate, $endDate])
                    ->where('order_status', 1);
            })
            ->groupBy('product_id')
            ->orderBy('total_qty', 'desc')
            ->limit(10)
            ->get();

        return view('report.best-seller', compact('bestSellers', 'startDate', 'endDate'));
    }
}
