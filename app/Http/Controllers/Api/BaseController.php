<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AlamatToko;
use Illuminate\Support\Facades\Validator;
use App\Http\Helper;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{

    public function upload(Request $request, $path) {
        $fileName = "";
        if ($request->image) {
            $image = $request->image->getClientOriginalName();
            $image = str_replace(' ', '', $image);
            $image = date('Hs') . rand(1, 999) . "_" . $image;
            $fileName = $image;
            $request->image->storeAs('public/' . $path, $image);
            return $this->success($fileName);
        } else {
            return $this->error("Image wajib di kirim");
        }
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
