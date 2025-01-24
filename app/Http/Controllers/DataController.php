<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\General;

class DataController extends Controller
{
    public function getDataCategory()
    {
        $response = General::checkJWT();
        if ($response === false) {
            return ApiResponse::error();
        }

        try {
            $dataCategory = DB::table("product_category")->select("id", "name")->get();
            return ApiResponse::success([
                'category' => $dataCategory
            ], '');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error();
        }
    }
}