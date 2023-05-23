<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'userId' => 'required',
            'name' => 'required',
            'kota' => 'required',
        ]);

        if($validasi->fails()){
            return $this->error($validasi->errors()->first());
        }

        $toko = Toko::create($request->all());
        return $this->success($toko);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function cekToko($id){
        $user = User::where('id', $id)->with(['toko', 'userRole'])->first();
        if ($user){
            return $this->success($user);
        } else {
            return $this->error("user tidak ditemukan");
        }
    }

    public function success($data, $message = "success"){
        return response()->json([
            'code' => 200,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function error($message){
        return response()->json([
            'code' => 400,
            'message' => $message
        ], 400);
    }
}
