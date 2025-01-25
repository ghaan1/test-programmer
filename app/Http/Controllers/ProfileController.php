<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Helpers\General;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ProfileController extends Controller
{
    public function getData(Request $request)
    {
        $response = General::checkJWT();
        if ($response === false) {
            return ApiResponse::error("Token invalid", 401);
        }

        $user = Auth::user();

        return ApiResponse::success([
            'data' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'position' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $response = General::checkJWT();
            if ($response === false) {
                return ApiResponse::error("Token invalid", 401);
            }

            $user = Auth::user();

            $user->name = $request->name;
            $user->position = $request->position;

            if ($request->hasFile('image')) {
                if ($user->image) {
                    Storage::delete($user->image);
                }

                $path = $request->file('image')->store('profiles');
                $user->image = $path;
            }

            $user->save();

            return ApiResponse::success([
                'data' => $user,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return ApiResponse::error("Validation failed.", 422, $e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return ApiResponse::error("An error occurred: " . $e->getMessage(), 500);
        } finally {
            DB::commit();
        }
    }
}