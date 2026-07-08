<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderService
{
    /**
     * Membuat order baru dalam transaksi yang aman.
     * 
     * @param int $userId ID pengguna (pembeli/kasir)
     * @param array $items Array data item (format kasir: ['product_id', 'jumlah']) atau Array of Cart IDs (format online)
     * @param string $tipe Tipe pesanan ('online' atau 'kasir')
     * @param float $uangDibayar Uang yang dibayarkan pelanggan (kasir). Untuk online, biasanya sama dengan total.
     * @return Order
     * @throws Exception
     */
    public function createOrder($userId, $items, $tipe = 'online', $uangDibayar = null)
    {
        return DB::transaction(function () use ($userId, $items, $tipe, $uangDibayar) {
            $totalHarga = 0;
            $orderItems = [];
            $cartsToDelete = [];

            if ($tipe === 'online') {
                // Proses Online: items berupa array of cart IDs
                $carts = Cart::with('product')->where('user_id', $userId)->whereIn('id', $items)->get();
                
                if ($carts->isEmpty()) {
                    throw new Exception('Produk di keranjang tidak ditemukan atau tidak valid.');
                }

                foreach ($carts as $cart) {
                    $product = $cart->product;
                    
                    if ($product->stok < $cart->jumlah) {
                        throw new Exception("Stok {$product->nama_produk} tidak mencukupi.");
                    }

                    $subtotal = $product->harga * $cart->jumlah;
                    $totalHarga += $subtotal;

                    $orderItems[] = [
                        'product_id'  => $product->id,
                        'nama_produk' => $product->nama_produk,
                        'jumlah'      => $cart->jumlah,
                        'harga'       => $product->harga,
                        'harga_modal' => $product->harga_modal,
                        'subtotal'    => $subtotal,
                    ];
                    $cartsToDelete[] = $cart->id;
                }
            } else {
                // Proses Kasir: items berupa array asosiatif ['product_id', 'jumlah']
                $productIds = collect($items)->pluck('product_id');
                $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

                foreach ($items as $item) {
                    if (!isset($products[$item['product_id']])) {
                        throw new Exception('Sebagian produk tidak ditemukan dalam katalog.');
                    }
                    $product = $products[$item['product_id']];

                    if ($product->stok < $item['jumlah']) {
                        throw new Exception("Stok {$product->nama_produk} tidak mencukupi.");
                    }

                    $subtotal = $product->harga * $item['jumlah'];
                    $totalHarga += $subtotal;

                    $orderItems[] = [
                        'product_id'  => $product->id,
                        'nama_produk' => $product->nama_produk,
                        'jumlah'      => $item['jumlah'],
                        'harga'       => $product->harga,
                        'harga_modal' => $product->harga_modal,
                        'subtotal'    => $subtotal,
                    ];
                }
            }

            if ($tipe === 'kasir') {
                if ($uangDibayar < $totalHarga) {
                    throw new Exception('Uang yang dibayarkan kurang.');
                }
                $kembalian = $uangDibayar - $totalHarga;
                $status = 'selesai';
            } else {
                $uangDibayar = $totalHarga; // Online payment implementation pending
                $kembalian = 0;
                $status = 'pending';
            }

            // Create Order
            $order = Order::create([
                'user_id'        => $userId,
                'kode_transaksi' => Order::generateKode(),
                'total_harga'    => $totalHarga,
                'uang_dibayar'   => $uangDibayar,
                'kembalian'      => $kembalian,
                'status'         => $status,
                'tipe'           => $tipe,
            ]);

            // Create Order Items & Decrement Stock
            foreach ($orderItems as $item) {
                $order->items()->create($item);

                Product::where('id', $item['product_id'])
                    ->decrement('stok', $item['jumlah']);
            }

            // Clean up cart for online orders
            if ($tipe === 'online' && !empty($cartsToDelete)) {
                Cart::whereIn('id', $cartsToDelete)->delete();
            }

            return $order;
        });
    }
}
