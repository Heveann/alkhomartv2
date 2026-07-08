<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
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
        ];
    }
}
