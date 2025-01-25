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
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index');
    }

    public function create()
    {
        return view('product.create');
    }

    public function edit()
    {
        return view('product.edit');
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
                ->leftJoin('product_category', 'product.fk_product_category', '=', 'product_category.id')
                ->orderBy('product.created_at', 'desc');

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

            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);
            $product = $query->paginate($perPage, ['*'], 'page', $page);

            if ($product->isEmpty()) {
                return ApiResponse::error('Produk tidak ditemukan', 404);
            }

            return ApiResponse::success([
                'product' => ProductResource::collection($product),
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

    public function store(ProductRequest $request)
    {
        $response = General::checkJWT();
        if ($response === false) {
            return ApiResponse::error("Token invalid", 401);
        }

        DB::beginTransaction();

        try {
            $imagePath = null;
            $idProduct = "P" . General::generateId();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = $idProduct . "-" . General::microseconds() . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('images', $fileName, 'public');
            }

            DB::table('product')->insert([
                'id' => $idProduct,
                'fk_product_category' => $request->category,
                'name' => $request->name,
                'price' => $request->buy_price,
                'selling_price' => $request->buy_price * 1.30,
                'stock'  => $request->stock,
                'image' => $imagePath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::commit();

            return ApiResponse::success([]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return ApiResponse::error($e->getMessage());
        }
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $response = General::checkJWT();
        if ($response === false) {
            return ApiResponse::error("Token invalid", 401);
        }

        DB::beginTransaction();

        try {
            $product = DB::table('product')->where('id', $id)->first();
            if (!$product) {
                return ApiResponse::error("Produk tidak ditemukan", 404);
            }

            $imagePath = $product->image;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = $id . "-" . General::microseconds() . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('images', $fileName, 'public');
            }
            DB::table('product')->where('id', $id)->update([
                'fk_product_category' => $request->category,
                'name' => $request->name,
                'price' => $request->buy_price,
                'selling_price' => $request->buy_price * 1.30,
                'stock'  => $request->stock,
                'image' => $imagePath,
                'updated_at' => now(),
            ]);


            DB::commit();
            return ApiResponse::success([]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return ApiResponse::error($e->getMessage());
        }
    }

    public function show($id)
    {
        $response = General::checkJWT();
        if ($response === false) {
            return ApiResponse::error("Token invalid", 401);
        }

        try {
            $product = DB::table('product')
                ->join('product_category', 'product.fk_product_category', '=', 'product_category.id')
                ->where('product.id', $id)
                ->select(
                    'product.id',
                    'product.name',
                    'product.fk_product_category',
                    'product_category.name as category_name',
                    'product.price',
                    'product.selling_price',
                    'product.stock',
                    'product.image',
                )
                ->first();


            $product->image = Storage::url($product->image);


            if (!$product) {
                return ApiResponse::error("Produk tidak ditemukan", 404);
            }

            return ApiResponse::success(['product' => $product]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error($e->getMessage());
        }
    }


    public function destroy($id)
    {
        $response = General::checkJWT();
        if ($response === false) {
            return ApiResponse::error("Token invalid", 401);
        }

        DB::beginTransaction();

        try {
            $product = DB::table('product')->where('id', $id)->first();
            if (!$product) {
                return ApiResponse::error("Produk tidak ditemukan", 404);
            }

            DB::table('product')->where('id', $id)->delete();

            DB::commit();
            return ApiResponse::success([]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return ApiResponse::error($e->getMessage());
        }
    }

    public function export(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $category = $request->input('category');

        return Excel::download(new ProductsExport($searchTerm, $category), 'products.xlsx');
    }
}