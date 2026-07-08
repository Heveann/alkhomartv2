<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Product::count();
        $totalTransaksi = Order::where('status', 'selesai')->count();
        $totalPendapatan = Order::where('status', 'selesai')->sum('total_harga');

        $totalLaba = OrderItem::whereHas('order', function ($q) {
            $q->where('status', 'selesai');
        })->sum(DB::raw('(harga - harga_modal) * jumlah'));

        $recentOrders = Order::with('user')
            ->where('status', 'selesai')
            ->latest()
            ->take(5)
            ->get();

        $transaksiHariIni = Order::where('status', 'selesai')
            ->whereDate('created_at', today())
            ->count();

        $pendapatanHariIni = Order::where('status', 'selesai')
            ->whereDate('created_at', today())
            ->sum('total_harga');

        $chartDataOnline = array_fill(0, 12, 0);
        $chartDataOffline = array_fill(0, 12, 0);
        $chartLabels = [];
        $currentYear = date('Y');
        
        for ($month = 1; $month <= 12; $month++) {
            $date = \Carbon\Carbon::createFromDate($currentYear, $month, 1);
            $chartLabels[] = $date->translatedFormat('F'); // Full month name
        }

        $chartDataOnline = Cache::remember('dashboard_chart_online_' . $currentYear, 600, function () use ($currentYear) {
            $data = array_fill(0, 12, 0);
            $monthlyRevenues = Order::where('status', 'selesai')
                ->where('tipe', 'online')
                ->whereYear('created_at', $currentYear)
                ->selectRaw('MONTH(created_at) as month, SUM(total_harga) as total')
                ->groupBy('month')
                ->pluck('total', 'month');

            foreach ($monthlyRevenues as $month => $total) {
                $data[$month - 1] = $total;
            }
            return $data;
        });

        $chartDataOffline = Cache::remember('dashboard_chart_offline_' . $currentYear, 600, function () use ($currentYear) {
            $data = array_fill(0, 12, 0);
            $monthlyRevenues = Order::where('status', 'selesai')
                ->where('tipe', 'kasir')
                ->whereYear('created_at', $currentYear)
                ->selectRaw('MONTH(created_at) as month, SUM(total_harga) as total')
                ->groupBy('month')
                ->pluck('total', 'month');

            foreach ($monthlyRevenues as $month => $total) {
                $data[$month - 1] = $total;
            }
            return $data;
        });

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalTransaksi',
            'totalPendapatan',
            'totalLaba',
            'recentOrders',
            'transaksiHariIni',
            'pendapatanHariIni',
            'chartLabels',
            'chartDataOnline',
            'chartDataOffline'
        ));
    }
}
