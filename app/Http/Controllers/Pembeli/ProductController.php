<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('stok', '>', 0);

        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12);

        return view('pembeli.products.index', compact('products'));
    }

    /**
     * Endpoint API untuk live search produk via Fetch API.
     * GET /produk/search?q=keyword
     */
    public function search(Request $request)
    {
        $keyword = $request->input('q', '');

        $products = Product::where('stok', '>', 0)
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('nama_produk', 'like', '%' . $keyword . '%');
            })
            ->latest()
            ->limit(20)
            ->get()
            ->map(function ($product) {
                return [
                    'id'         => $product->id,
                    'nama_produk'=> $product->nama_produk,
                    'harga'      => $product->harga,
                    'harga_fmt'  => 'IDR ' . number_format($product->harga, 0, ',', '.'),
                    'stok'       => $product->stok,
                    'gambar'     => $product->gambar ? asset('storage/' . $product->gambar) : null,
                    'url'        => route('pembeli.products.show', $product->id),
                ];
            });

        return response()->json([
            'keyword'  => $keyword,
            'count'    => $products->count(),
            'products' => $products,
        ]);
    }

    public function show(Product $product)
    {
        return view('pembeli.products.show', compact('product'));
    }
}
