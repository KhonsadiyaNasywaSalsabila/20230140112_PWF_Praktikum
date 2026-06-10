<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori beserta jumlah produknya.
     */
    public function index()
    {
        // withCount('products') akan otomatis menghitung total produk per kategori
        $categories = Category::withCount('products')->get();
        
        return view('category.index', compact('categories'));
    }

    /**
     * Menampilkan form untuk menambah kategori baru.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Menyimpan data kategori baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama kategori ini sudah ada, silakan gunakan nama lain.',
        ]);

        // Menyimpan data
        Category::create($validated);

        return redirect()->route('category.index')->with('success', 'Category created successfully.');
    }

    /**
     * Menampilkan form untuk mengedit kategori.
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Memperbarui data kategori di database.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        // Validasi input (Pengecualian unique untuk ID kategori yang sedang diedit)
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ], [
            'name.required' => 'Nama kategori tidak boleh dikosongkan.',
            'name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama kategori ini sudah digunakan.',
        ]);

        // Memperbarui data
        $category->update($validated);

        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Menghapus kategori dari database.
     */
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }
}