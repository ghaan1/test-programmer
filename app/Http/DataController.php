<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DataController extends Controller
{
    public function getDataCategory()
    {
        try {
            $dataCategory = DB::table("product_category")->select("id", "name");
            $query = $dataCategory->get();
            return ApiResponse::success([
                'category' => $query
            ], '');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error();
        }
    }
}
