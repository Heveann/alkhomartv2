<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Http\Requests\ProcessKasirRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
    {
        $products = Product::where('stok', '>', 0)
            ->select('id', 'nama_produk', 'harga', 'stok', 'gambar')
            ->get();
            
        return view('admin.kasir.index', compact('products'));
    }

    public function process(ProcessKasirRequest $request, OrderService $orderService)
    {
        try {
            $order = $orderService->createOrder(
                auth()->id(),
                $request->items,
                'kasir',
                $request->uang_dibayar
            );
            return redirect()->route('admin.kasir.receipt', $order->id);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function receipt(Order $order)
    {
        $order->load('items');
        return view('admin.kasir.receipt', compact('order'));
    }
}
