<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AlamatToko;
use Illuminate\Support\Facades\Validator;
use App\Http\Helper;
use App\Models\Category;
use App\Models\Produk;
use App\Models\Slider;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{

    public function getHome() {
        $categories = Category::where('isActive', true)->get();
        $sliders = Slider::where('isActive', true)->get();
        $products = Produk::where('isActive', true)
        ->with([
            'store:id,name',
            'store.address:id,tokoId,kota',
        ])
        ->select(['id', 'tokoId', 'name', 'price', 'sold', 'images'])
        ->orderBy('sold', 'desc')
        ->get()
        ->take(8);

        $data = [
            'categories' => $categories,
            'products' => $products,
            'sliders' => $sliders
        ];

        return $this->success($data);
    }

    public function success($data, $message = "success"): JsonResponse {
        return response()->json([
            'code' => 200,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function error($message): JsonResponse{
        return response()->json([
            'code' => 400,
            'message' => $message
        ], 400);
    }
}
