<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $productId = $this->route('id');

        return [
            'category' => 'required|exists:product_category,id',
            'name' => 'required|string|unique:product,name,' . $productId,
            'buy_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:100',
        ];
    }

    public function messages()
    {
        return [
            'category.required' => 'Kategori produk harus dipilih.',
            'category.exists' => 'Kategori produk tidak valid.',
            'name.required' => 'Nama produk harus diisi.',
            'name.string' => 'Nama produk harus berupa teks.',
            'name.unique' => 'Nama produk sudah terdaftar.',
            'buy_price.required' => 'Harga beli produk harus diisi.',
            'buy_price.numeric' => 'Harga beli harus berupa angka.',
            'sell_price.required' => 'Harga jual produk harus diisi.',
            'sell_price.numeric' => 'Harga jual harus berupa angka.',
            'stock.required' => 'Stok produk harus diisi.',
            'stock.numeric' => 'Stok harus berupa angka.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar maksimal 100KB.',
        ];
    }
}