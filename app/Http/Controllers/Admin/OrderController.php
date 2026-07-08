<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Order::with('user', 'items')->latest();

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('tipe')) {
                $query->where('tipe', $request->tipe);
            }


            if ($request->filled('period')) {
                $period = $request->period;
                if ($period === '1_hour') {
                    $query->where('created_at', '>=', now()->subHour());
                } elseif ($period === '1_day') {
                    $query->where('created_at', '>=', now()->subDay());
                } elseif ($period === '1_week') {
                    $query->where('created_at', '>=', now()->subWeek());
                } elseif ($period === '1_month') {
                    $query->where('created_at', '>=', now()->subMonth());
                } elseif ($period === '1_year') {
                    $query->where('created_at', '>=', now()->subYear());
                }
            }

            if ($request->filled('filter_bulan')) {
                $month = date('m', strtotime($request->filter_bulan));
                $year = date('Y', strtotime($request->filter_bulan));
                $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('kode_transaksi', function ($order) {
                    return '<a href="' . route('admin.orders.show', $order) . '" class="text-decoration-none fw-bold text-primary">' . $order->kode_transaksi . '</a>';
                })
                ->addColumn('pelanggan', function ($order) {
                    return $order->user ? $order->user->name : 'Walk-in Customer';
                })
                ->editColumn('tipe', function ($order) {
                    if ($order->tipe === 'online') {
                        return '<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-blue-100 text-blue-700"><i class="bi bi-globe mr-1"></i>Online</span>';
                    } else {
                        return '<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-slate-100 text-slate-700"><i class="bi bi-shop mr-1"></i>Offline</span>';
                    }
                })
                ->editColumn('status', function ($order) {
                    if ($order->status === 'selesai') {
                        return '<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-100 text-emerald-700"><i class="bi bi-check-circle mr-1"></i>Selesai</span>';
                    } elseif ($order->status === 'dibatalkan') {
                        return '<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-red-100 text-red-700"><i class="bi bi-x-circle mr-1"></i>Dibatalkan</span>';
                    } else {
                        return '<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-amber-100 text-amber-700"><i class="bi bi-clock mr-1"></i>Pending</span>';
                    }
                })
                ->editColumn('total_harga', function ($order) {
                    return 'Rp ' . number_format($order->total_harga, 0, ',', '.');
                })
                ->editColumn('created_at', function ($order) {
                    return $order->created_at->format('d M Y H:i');
                })
                ->addColumn('action', function ($order) {
                    $html = '<div class="flex items-center justify-end gap-2">';
                    
                    if ($order->status === 'pending') {
                        $html .= '
                        <form action="' . route('admin.orders.updateStatus', $order) . '" method="POST" class="m-0 relative group">
                            ' . csrf_field() . '
                            ' . method_field('PATCH') . '
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" onclick="confirmStatusUpdate(event, this.form, \'Tandai pesanan ini sebagai selesai?\', \'Ya, Selesai!\', \'#00ac69\', \'success\')" 
                                    class="w-9 h-9 flex items-center justify-center rounded-lg btn-action-success transition-all focus:outline-none">
                                <i class="bi bi-check-lg text-lg"></i>
                            </button>
                            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-50">
                                <div class="text-white text-xs tracking-wide px-2.5 py-1 rounded-[4px] shadow-sm whitespace-nowrap relative" style="background-color: #1e293b;">
                                    Selesai
                                    <div class="absolute top-full left-1/2 -translate-x-1/2 border-[5px] border-transparent" style="border-top-color: #1e293b;"></div>
                                </div>
                            </div>
                        </form>
                        
                        <form action="' . route('admin.orders.updateStatus', $order) . '" method="POST" class="m-0 relative group">
                            ' . csrf_field() . '
                            ' . method_field('PATCH') . '
                            <input type="hidden" name="status" value="dibatalkan">
                            <button type="submit" onclick="confirmStatusUpdate(event, this.form, \'Apakah Anda yakin ingin membatalkan pesanan ini?\', \'Ya, Batalkan!\', \'#e81500\', \'warning\')" 
                                    class="w-9 h-9 flex items-center justify-center rounded-lg btn-action-danger transition-all focus:outline-none">
                                <i class="bi bi-x-lg text-lg"></i>
                            </button>
                            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-50">
                                <div class="text-white text-xs tracking-wide px-2.5 py-1 rounded-[4px] shadow-sm whitespace-nowrap relative" style="background-color: #1e293b;">
                                    Batalkan
                                    <div class="absolute top-full left-1/2 -translate-x-1/2 border-[5px] border-transparent" style="border-top-color: #1e293b;"></div>
                                </div>
                            </div>
                        </form>';
                    }

                    $html .= '
                    <div class="relative group">
                        <a href="' . route('admin.orders.show', $order) . '" 
                           class="w-9 h-9 flex items-center justify-center rounded-lg btn-action-primary transition-all focus:outline-none">
                            <i class="bi bi-file-earmark-text text-lg"></i>
                        </a>
                        <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-50">
                            <div class="text-white text-xs tracking-wide px-2.5 py-1 rounded-[4px] shadow-sm whitespace-nowrap relative" style="background-color: #1e293b;">
                                Detail
                                <div class="absolute top-full left-1/2 -translate-x-1/2 border-[5px] border-transparent" style="border-top-color: #1e293b;"></div>
                            </div>
                        </div>
                    </div>
                    </div>';

                    return $html;
                })
                ->rawColumns(['kode_transaksi', 'tipe', 'status', 'action'])
                ->make(true);
        }

        return view('admin.orders.index');
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function exportPdf(Request $request)
    {
        // Force only 'selesai' orders for export
        $query = Order::with('user', 'items')->where('status', 'selesai')->latest();

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('period')) {
            $period = $request->period;
            if ($period === '1_hour') {
                $query->where('created_at', '>=', now()->subHour());
            } elseif ($period === '1_day') {
                $query->where('created_at', '>=', now()->subDay());
            } elseif ($period === '1_week') {
                $query->where('created_at', '>=', now()->subWeek());
            } elseif ($period === '1_month') {
                $query->where('created_at', '>=', now()->subMonth());
            } elseif ($period === '1_year') {
                $query->where('created_at', '>=', now()->subYear());
            }
        }

        if ($request->filled('filter_bulan')) {
            $month = date('m', strtotime($request->filter_bulan));
            $year = date('Y', strtotime($request->filter_bulan));
            $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
        }

        $orders = $query->with(['user', 'items.product'])->limit(1000)->get();
        $pdf = Pdf::loadView('admin.orders.export_pdf', compact('orders'));
        return $pdf->download('Rekap_Pesanan_' . date('Y-m-d') . '.pdf');
    }

    public function pdf(Order $order)
    {
        $order->load('user', 'items.product');
        $pdf = Pdf::loadView('admin.orders.pdf', compact('order'));
        return $pdf->download('Invoice-' . $order->kode_transaksi . '.pdf');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,selesai,dibatalkan'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
