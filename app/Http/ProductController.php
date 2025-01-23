<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index');
    }

    public function getData()
    {
        try {
            $query = DB::table('product')
                ->select(
                    'product.id',
                    'product.name',
                    'product_category.name as category_name',
                    'product.price',
                    'product.selling_price',
                    'product.stock',
                    'product.image',
                )
                ->leftJoin('product_category', 'product.fk_product_category', '=', 'product_category.id');

            $product = $query->paginate(10);

            if ($product->isEmpty()) {
                return ApiResponse::error('Produk tidak ditemukan', 404);
            }

            return ApiResponse::success([
                'product' => ProductResource::collection($product->items()),
                'pagination' => [
                    'current_page' => $product->currentPage(),
                    'per_page' => $product->perPage(),
                    'total' => $product->total(),
                    'last_page' => $product->lastPage(),
                ],
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error();
        }
    }
}
