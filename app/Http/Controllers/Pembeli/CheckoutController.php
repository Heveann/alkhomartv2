<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Http\Requests\CheckoutRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $itemIds = $request->items;

        if (empty($itemIds) || !is_array($itemIds)) {
            return redirect()->route('pembeli.cart')
                ->with('error', 'Pilih setidaknya satu produk untuk di-checkout.');
        }

        $carts = Cart::with('product')
            ->where('user_id', auth()->id())
            ->whereIn('id', $itemIds)
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('pembeli.cart')
                ->with('error', 'Produk tidak ditemukan atau tidak valid.');
        }

        $total = $carts->sum(function ($cart) {
            return $cart->product->harga * $cart->jumlah;
        });

        return view('pembeli.checkout.index', compact('carts', 'total'));
    }

    public function process(CheckoutRequest $request, OrderService $orderService)
    {
        try {
            $order = $orderService->createOrder(auth()->id(), $request->items, 'online');
            return redirect()->route('pembeli.checkout.success', $order->id);
        } catch (\Exception $e) {
            return redirect()->route('pembeli.cart')->with('error', $e->getMessage());
        }
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
