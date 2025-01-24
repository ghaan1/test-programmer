<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\General;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index');
    }

    public function getData(Request $request)
    {

        $response = General::checkJWT();
        if ($response === false) {
            return ApiResponse::error();
        }

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

            if ($request->has('searchTerm') && $request->searchTerm != '') {
                $searchTerm = '%' . $request->searchTerm . '%';

                $query->where(function ($q) use ($searchTerm) {
                    $q->where('product.name', 'ILIKE', $searchTerm)
                        ->orWhere('product.price', 'ILIKE', $searchTerm)
                        ->orWhere('product.selling_price', 'ILIKE', $searchTerm)
                        ->orWhere('product.stock', 'ILIKE', $searchTerm);
                });
            }


            if ($request->has('category') && $request->category != '') {
                $query->where('product.fk_product_category', $request->category);
            }

            $product = $query->paginate($request->get('per_page', 10));

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
                    'total_data_page' => $product->count(),
                ],
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error();
        }
    }
}