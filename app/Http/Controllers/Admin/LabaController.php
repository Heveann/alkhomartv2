<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LabaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Order::with('items')->where('status', 'selesai');

            if ($request->filled('tanggal_dari')) {
                $query->whereDate('created_at', '>=', $request->tanggal_dari);
            }

            if ($request->filled('tanggal_sampai')) {
                $query->whereDate('created_at', '<=', $request->tanggal_sampai);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('kode_transaksi', function ($order) {
                    return '<a href="' . route('admin.orders.show', $order) . '" class="text-decoration-none fw-bold text-primary">' . $order->kode_transaksi . '</a>';
                })
                ->addColumn('laba_kotor', function ($order) {
                    $modal = 0;
                    foreach ($order->items as $item) {
                        $modal += $item->harga_modal * $item->jumlah;
                    }
                    $laba = $order->total_harga - $modal;
                    return 'Rp ' . number_format($laba, 0, ',', '.');
                })
                ->editColumn('total_harga', function ($order) {
                    return 'Rp ' . number_format($order->total_harga, 0, ',', '.');
                })
                ->addColumn('total_modal', function ($order) {
                    $modal = 0;
                    foreach ($order->items as $item) {
                        $modal += $item->harga_modal * $item->jumlah;
                    }
                    return 'Rp ' . number_format($modal, 0, ',', '.');
                })
                ->editColumn('created_at', function ($order) {
                    return $order->created_at->format('d M Y H:i');
                })
                ->rawColumns(['kode_transaksi'])
                ->make(true);
        }

        // Keep the old logic for calculating totals in the cards
        $query = Order::where('status', 'selesai');

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }

        $totalPendapatan = $query->sum('total_harga');

        $baseItemQuery = OrderItem::whereHas('order', function ($q) use ($request) {
            $q->where('status', 'selesai');
            if ($request->filled('tanggal_dari')) {
                $q->whereDate('created_at', '>=', $request->tanggal_dari);
            }
            if ($request->filled('tanggal_sampai')) {
                $q->whereDate('created_at', '<=', $request->tanggal_sampai);
            }
        });

        // Clone query so we don't apply multiple DB raw statements on the same object
        $totalModal = (clone $baseItemQuery)->sum(DB::raw('harga_modal * jumlah'));
        $totalLaba = (clone $baseItemQuery)->sum(DB::raw('(harga - harga_modal) * jumlah'));

        return view('admin.laba.index', compact(
            'totalPendapatan',
            'totalModal',
            'totalLaba'
        ));
    }
}
