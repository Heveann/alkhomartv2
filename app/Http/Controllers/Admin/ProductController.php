<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::with('category');
            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('category_name', function ($product) {
                    return $product->category ? $product->category->name : 'Uncategorized';
                })
                ->editColumn('gambar', function ($product) {
                    if ($product->gambar) {
                        return '<div class="w-12 h-12 rounded-xl overflow-hidden shadow-sm border border-slate-100 shrink-0"><img src="' . asset('storage/' . $product->gambar) . '" class="w-full h-full object-cover"></div>';
                    }
                    return '<div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center shadow-sm border border-slate-100 shrink-0"><i class="bi bi-image text-slate-300 text-xl"></i></div>';
                })
                ->editColumn('harga', function ($product) {
                    return 'Rp ' . number_format($product->harga, 0, ',', '.');
                })
                ->editColumn('harga_modal', function ($product) {
                    return 'Rp ' . number_format($product->harga_modal, 0, ',', '.');
                })
                ->editColumn('stok', function ($product) {
                    if ($product->stok > 10) {
                        return '<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">' . $product->stok . '</span>';
                    } elseif ($product->stok > 0) {
                        return '<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">' . $product->stok . '</span>';
                    } else {
                        return '<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-red-50 text-red-700 border border-red-100">Habis</span>';
                    }
                })
                ->addColumn('stok_raw', function ($product) {
                    return $product->stok;
                })
                ->addColumn('action', function ($product) {
                    return '<div class="flex items-center justify-end gap-2">
                                <button type="button" onclick="openEditModal(' . $product->id . ')" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </button>
                                <form action="' . route('admin.products.destroy', $product) . '" method="POST" class="inline-block" onsubmit="confirmDelete(event, this)">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                        <i class="bi bi-trash3 text-lg"></i>
                                    </button>
                                </form>
                            </div>';
                })
                ->rawColumns(['gambar', 'stok', 'action'])
                ->make(true);
        }

        return view('admin.products.index', [
            'totalProducts'   => Product::count(),
            'lowStockCount'   => Product::where('stok', '<=', 10)->count(),
            'totalValue'      => Product::selectRaw('SUM(harga * stok) as total')->value('total') ?? 0,
            'categories'      => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * GET /admin/products/{product}/edit-data
     * Mengembalikan data produk dalam format JSON untuk modal edit.
     */
    public function getEditData(Product $product)
    {
        $product->load(['sizes', 'images']);
        return response()->json([
            'id'          => $product->id,
            'nama_produk' => $product->nama_produk,
            'category_id' => $product->category_id,
            'harga'       => (int) $product->harga,
            'harga_modal' => (int) $product->harga_modal,
            'stok'        => $product->stok,
            'images'      => $product->images->map(fn($img) => ['id' => $img->id, 'url' => $img->url]),
            'sizes'       => $product->sizes->map(fn($s) => ['size' => $s->size, 'stock' => $s->stock]),
            'update_url'  => route('admin.products.update', $product->id),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'harga' => 'required|numeric|min:0',
            'harga_modal' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|array',
            'gambar.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'sizes' => 'nullable|array',
            'sizes.*.size' => 'required_with:sizes|string|max:50',
            'sizes.*.stock' => 'required_with:sizes|integer|min:0',
        ]);

        $data = $request->only(['nama_produk', 'category_id', 'harga', 'harga_modal', 'stok']);

        $product = Product::create($data);

        if ($request->hasFile('gambar')) {
            $firstPath = null;
            foreach ($request->file('gambar') as $index => $file) {
                $path = $file->store('products', 'public');
                if ($index === 0) {
                    $firstPath = $path;
                }
                $product->images()->create([
                    'path' => $path,
                    'order' => $index,
                ]);
            }
            // Update backward-compatible field
            if ($firstPath) {
                $product->update(['gambar' => $firstPath]);
            }
        }

        if ($request->has('sizes')) {
            foreach ($request->sizes as $sizeData) {
                if (!empty($sizeData['size'])) {
                    $product->sizes()->create([
                        'size' => $sizeData['size'],
                        'stock' => $sizeData['stock'] ?? 0,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'harga' => 'required|numeric|min:0',
            'harga_modal' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|array',
            'gambar.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'sizes' => 'nullable|array',
            'sizes.*.size' => 'required_with:sizes|string|max:50',
            'sizes.*.stock' => 'required_with:sizes|integer|min:0',
        ]);

        $data = $request->only(['nama_produk', 'category_id', 'harga', 'harga_modal', 'stok']);
        $product->update($data);

        if ($request->hasFile('gambar')) {
            $lastOrder = $product->images()->max('order') ?? -1;
            foreach ($request->file('gambar') as $file) {
                $lastOrder++;
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'path' => $path,
                    'order' => $lastOrder,
                ]);
            }
        }

        // Sinkronisasi field 'gambar' (backward compatible)
        $firstImage = $product->images()->orderBy('order')->first();
        if ($firstImage && $product->gambar !== $firstImage->path) {
            $product->update(['gambar' => $firstImage->path]);
        } elseif (!$firstImage && $product->gambar) {
            Storage::disk('public')->delete($product->gambar);
            $product->update(['gambar' => null]);
        }

        $product->sizes()->delete();
        if ($request->has('sizes')) {
            foreach ($request->sizes as $sizeData) {
                if (!empty($sizeData['size'])) {
                    $product->sizes()->create([
                        'size' => $sizeData['size'],
                        'stock' => $sizeData['stock'] ?? 0,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->path);
        }
        if ($product->gambar && !$product->images->where('path', $product->gambar)->count()) {
             Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    public function destroyImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        Storage::disk('public')->delete($image->path);
        $image->delete();

        // Sync first image
        $firstImage = $product->images()->orderBy('order')->first();
        if ($firstImage) {
            $product->update(['gambar' => $firstImage->path]);
        } else {
            $product->update(['gambar' => null]);
        }

        return response()->json(['success' => true]);
    }
}
