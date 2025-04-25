<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Orders_Details;
use Carbon\Carbon;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Laporan Harian
    public function dailyReport(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());

        $orders = Orders::with('Orders_Details.product')
            ->whereDate('order_date', $date)
            ->where('order_status', 1) // Hanya transaksi yang selesai
            ->orderBy('order_date', 'desc')
            ->get();

        $totalAmount = $orders->sum('order_amount');
        $totalTransactions = $orders->count();

        return view('reports.daily', compact('orders', 'totalAmount', 'totalTransactions', 'date'));
    }

    // Laporan Mingguan
    public function weeklyReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfWeek());
        $endDate = $request->input('end_date', Carbon::now()->endOfWeek());

        $orders = Orders::with('Orders_Details.product')
            ->whereBetween('order_date', [$startDate, $endDate])
            ->where('order_status', 1)
            ->orderBy('order_date', 'desc')
            ->get();

        $totalAmount = $orders->sum('order_amount');
        $totalTransactions = $orders->count();

        // Data untuk chart mingguan
        $dailyData = Orders::whereBetween('order_date', [$startDate, $endDate])
            ->where('order_status', 1)
            ->selectRaw('DATE(order_date) as date, SUM(order_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('reports.weekly', compact('orders', 'totalAmount', 'totalTransactions', 'startDate', 'endDate', 'dailyData'));
    }

    // Laporan Bulanan
    public function monthlyReport(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $orders = Orders::with('Orders_Details.product')
            ->whereYear('order_date', $year)
            ->whereMonth('order_date', $month)
            ->where('order_status', 1)
            ->orderBy('order_date', 'desc')
            ->get();

        $totalAmount = $orders->sum('order_amount');
        $totalTransactions = $orders->count();

        // Data untuk chart bulanan
        $dailyData = Orders::whereYear('order_date', $year)
            ->whereMonth('order_date', $month)
            ->where('order_status', 1)
            ->selectRaw('DAY(order_date) as day, SUM(order_amount) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return view('reports.monthly', compact('orders', 'totalAmount', 'totalTransactions', 'month', 'year', 'dailyData'));
    }

    // Laporan Produk Terlaris
    public function bestSellerReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth());

        $bestSellers = Orders_Details::with('product')
            ->selectRaw('product_id, SUM(qty) as total_qty, SUM(order_subtotal) as total_amount')
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('order_date', [$startDate, $endDate])
                    ->where('order_status', 1);
            })
            ->groupBy('product_id')
            ->orderBy('total_qty', 'desc')
            ->limit(10)
            ->get();

        return view('reports.best-seller', compact('bestSellers', 'startDate', 'endDate'));
    }
}
