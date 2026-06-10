<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // 'sometimes' berarti rule ini hanya jalan jika input dikirim di form
            'name' => 'sometimes|required|string|max:255',
            'quantity' => 'sometimes|required|integer|min:0',
            'price' => 'sometimes|required|numeric|min:0',
            'user_id' => 'sometimes|required|exists:users,id',
            'category_id' => 'sometimes|required|exists:categories,id', // <-- Aturan untuk Kategori
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk tidak boleh dikosongkan.',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
            'quantity.required' => 'Jumlah (kuantitas) tidak boleh dikosongkan.',
            'quantity.integer' => 'Jumlah produk harus berupa angka bulat.',
            'quantity.min' => 'Jumlah produk tidak boleh kurang dari 0.',
            'price.required' => 'Harga produk tidak boleh dikosongkan.',
            'price.numeric' => 'Harga produk harus berupa angka yang valid.',
            'price.min' => 'Harga produk tidak boleh kurang dari 0.',
            'user_id.required' => 'Pemilik produk tidak boleh kosong.',
            'user_id.exists' => 'Pemilik produk yang dipilih tidak valid di sistem.',
            'category_id.required' => 'Kategori produk tidak boleh kosong.', // <-- Pesan Kategori
            'category_id.exists' => 'Kategori yang dipilih tidak valid di sistem.', // <-- Pesan Kategori
        ];
    }
}