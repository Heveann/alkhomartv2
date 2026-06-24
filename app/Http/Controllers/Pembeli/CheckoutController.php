<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('pembeli.cart')
                ->with('error', 'Keranjang kosong.');
        }

        $total = $carts->sum(function ($cart) {
            return $cart->product->harga * $cart->jumlah;
        });

        return view('pembeli.checkout.index', compact('carts', 'total'));
    }

    public function process(Request $request)
    {
        $carts = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('pembeli.cart')
                ->with('error', 'Keranjang kosong.');
        }

        // Validate stock
        foreach ($carts as $cart) {
            if ($cart->product->stok < $cart->jumlah) {
                return back()->with('error', "Stok {$cart->product->nama_produk} tidak mencukupi.");
            }
        }

        $totalHarga = $carts->sum(function ($cart) {
            return $cart->product->harga * $cart->jumlah;
        });

        $order = Order::create([
            'user_id' => auth()->id(),
            'kode_transaksi' => Order::generateKode(),
            'total_harga' => $totalHarga,
            'uang_dibayar' => $totalHarga,
            'kembalian' => 0,
            'status' => 'pending',
            'tipe' => 'online',
        ]);

        foreach ($carts as $cart) {
            $order->items()->create([
                'product_id' => $cart->product_id,
                'nama_produk' => $cart->product->nama_produk,
                'jumlah' => $cart->jumlah,
                'harga' => $cart->product->harga,
                'harga_modal' => $cart->product->harga_modal,
                'subtotal' => $cart->product->harga * $cart->jumlah,
            ]);

            // Kurangi stok
            Product::where('id', $cart->product_id)
                ->decrement('stok', $cart->jumlah);
        }

        // Kosongkan keranjang
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('pembeli.checkout.success', $order->id);
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items');
        return view('pembeli.checkout.success', compact('order'));
    }
}
