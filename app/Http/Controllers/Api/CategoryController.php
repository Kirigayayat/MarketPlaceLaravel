<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AlamatToko;
use Illuminate\Support\Facades\Validator;
use App\Http\Helper;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{

    public function index()
    {
        $alamat = Category::where('isActive', true)->get();
        return $this->success($alamat);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required',
        ]);

        if ($validasi->fails()) {
            return $this->error($validasi->errors()->first());
        }

        $toko = Category::create($request->all());
        return $this->success($toko);
    }

    public function show(string $id)
    {
        $alamat = Category::where('tokoId', $id)->where('isActive', true)->get();
        return $this->success($alamat);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $alamat = Category::where('id', $id)->first();
        if ($alamat) {
            $alamat->update($request->all());
            return $this->success($alamat);
        } else {
            return $this->error("Kategori tidak ditemukan");
        }
    }

    public function destroy(string $id)
    {
        $alamat = Category::where('id', $id)->first();
        if ($alamat) {
            $alamat->update([
                'isActive' => false
            ]);
            return $this->success($alamat, "Kategori dihapus");
        } else {
            return $this->error("Kategori tidak ditemukan");
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
