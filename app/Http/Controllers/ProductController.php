<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest; 

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('product.index', compact('products'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();

        return view('product.create', compact('users'));
    }

    // Ubah Request menjadi StoreProductRequest
    public function store(StoreProductRequest $request)
    {
        // Data sudah otomatis tervalidasi oleh StoreProductRequest sebelum masuk ke sini
        $validated = $request->validated();

        $product = Product::create($validated);

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('product.view', compact('product'));
    }

    public function edit(Product $product)
    {
        // Menggunakan Gate Facade untuk proteksi
        Gate::authorize('update', $product);

        $users = User::orderBy('name')->get();

        return view('product.edit', compact('product', 'users'));
    }

    // Ubah Request menjadi UpdateProductRequest
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        // Menggunakan Gate Facade untuk proteksi
        Gate::authorize('update', $product);

        // Data otomatis tervalidasi oleh UpdateProductRequest
        $validated = $request->validated();

        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        // Menggunakan Gate Facade untuk proteksi
        Gate::authorize('delete', $product);

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }
}