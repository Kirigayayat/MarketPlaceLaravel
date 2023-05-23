<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Helper;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ProdukController extends Controller {

    public function index()
    {
        //
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
            'tokoId' => 'required',
            'name' => 'required',
            'description' => 'required',
            'weight' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        if($validasi->fails()){
            return $this->error($validasi->errors()->first());
        }

        $toko = Produk::create($request->all());
        return $this->success($toko);
    }

    public function show(string $id): JsonResponse
    {
        $alamat = Produk::where('tokoId', $id)
            ->with(['category:id,name'])
            ->where('isActive', true)
            ->get();
        return $this->success($alamat);
    }

    public function detailProduct($id): JsonResponse {
        $product = Produk::where('id', $id)
            ->with([
                'category:id,name',
                'store:id,name',
                'store.address:id,tokoId,kota',
            ])
            ->where('isActive', true)
            ->first();
        if ($product) {
            return $this->success($product);
        }

        return $this->error("Produk tidak ada");

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
        $alamat = Produk::where('id', $id)->first();
        if ($alamat){
            $alamat->update($request->all());
            return $this->success($alamat);
        } else {
            return $this->error("Produk tidak ditemukan");
        }
    }

    public function destroy(string $id)
    {
        $alamat = Produk::where('id', $id)->first();
        if ($alamat){
            $alamat->update([
                'isActive' => false
            ]);
            return $this->success($alamat, "Produk berhasil dihapus");
        } else {
            return $this->error("Produk tidak ditemukan");
        }
    }

    public function upload(Request $request, $id) {
            $fileName = "";
            if ($request->image){
                $image = $request->image->getClientOriginalName();
                $image = str_replace(' ', '', $image);
                $image = date('Hs') . rand(1, 999) . "_" . $image;
                $fileName = $image;
                $request->image->storeAs('public/produk', $image);

                return $this->success($fileName);
            } else {
                return $this->error("Gambar wajib di kirim");
            }
    }

    public function success($data, $message = "success") {
        return response()->json([
            'code' => 200,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function error($message) {
        return response()->json([
            'code' => 400,
            'message' => $message
        ], 400);
    }
}
