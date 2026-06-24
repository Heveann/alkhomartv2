<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $total = $carts->sum(function ($cart) {
            return $cart->product->harga * $cart->jumlah;
        });

        return view('pembeli.cart.index', compact('carts', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'jumlah' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $jumlah = $request->jumlah ?? 1;

        if ($product->stok < $jumlah) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cart) {
            $cart->update(['jumlah' => $cart->jumlah + $jumlah]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'jumlah' => $jumlah,
            ]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        if ($cart->product->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart->update(['jumlah' => $request->jumlah]);

        return back()->with('success', 'Keranjang diperbarui!');
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();

        return back()->with('success', 'Item dihapus dari keranjang.');
    }
}
