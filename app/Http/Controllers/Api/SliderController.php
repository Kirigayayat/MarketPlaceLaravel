<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AlamatToko;
use Illuminate\Support\Facades\Validator;
use App\Http\Helper;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\JsonResponse;

class SliderController extends Controller
{

    public function index()
    {
        $alamat = Slider::where('isActive', true)->get();
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

        $toko = Slider::create($request->all());
        return $this->success($toko);
    }

    public function show(string $id)
    {
        $alamat = Slider::where('tokoId', $id)->where('isActive', true)->get();
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
        $alamat = Slider::where('id', $id)->first();
        if ($alamat) {
            $alamat->update($request->all());
            return $this->success($alamat);
        } else {
            return $this->error("Slider tidak ditemukan");
        }
    }

    public function destroy(string $id)
    {
        $alamat = Slider::where('id', $id)->first();
        if ($alamat) {
            $alamat->delete();
            return $this->success($alamat, "Slider berhasil dihapus");
        } else {
            return $this->error("Slider tidak ditemukan");
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
