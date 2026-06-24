<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::query();
            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('action', function ($category) {
                    return '<div class="flex justify-end gap-2">
                                <button type="button" onclick="openEditCategory(' . $category->id . ', \'' . addslashes($category->name) . '\')" class="flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 bg-slate-50 text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-colors" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="' . route('admin.categories.destroy', $category) . '" method="POST" class="inline-block m-0" onsubmit="confirmDelete(event, this)">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 bg-slate-50 text-red-600 hover:bg-red-50 hover:border-red-200 transition-colors" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.categories.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($request->only('name'));

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->only('name'));

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
