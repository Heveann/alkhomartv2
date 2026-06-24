<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
    {
        $products = Product::where('stok', '>', 0)->get();
        return view('admin.kasir.index', compact('products'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'uang_dibayar' => 'required|numeric|min:0',
        ]);

        $totalHarga = 0;
        $orderItems = [];

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);

            if ($product->stok < $item['jumlah']) {
                return back()->withErrors(['items' => "Stok {$product->nama_produk} tidak mencukupi."]);
            }

            $subtotal = $product->harga * $item['jumlah'];
            $totalHarga += $subtotal;

            $orderItems[] = [
                'product_id' => $product->id,
                'nama_produk' => $product->nama_produk,
                'jumlah' => $item['jumlah'],
                'harga' => $product->harga,
                'harga_modal' => $product->harga_modal,
                'subtotal' => $subtotal,
            ];
        }

        if ($request->uang_dibayar < $totalHarga) {
            return back()->withErrors(['uang_dibayar' => 'Uang yang dibayarkan kurang.']);
        }

        $kembalian = $request->uang_dibayar - $totalHarga;

        $order = Order::create([
            'user_id' => auth()->id(),
            'kode_transaksi' => Order::generateKode(),
            'total_harga' => $totalHarga,
            'uang_dibayar' => $request->uang_dibayar,
            'kembalian' => $kembalian,
            'status' => 'selesai',
            'tipe' => 'kasir',
        ]);

        foreach ($orderItems as $item) {
            $order->items()->create($item);

            // Kurangi stok
            Product::where('id', $item['product_id'])
                ->decrement('stok', $item['jumlah']);
        }

        return redirect()->route('admin.kasir.receipt', $order->id);
    }

    public function receipt(Order $order)
    {
        $order->load('items');
        return view('admin.kasir.receipt', compact('order'));
    }
}
