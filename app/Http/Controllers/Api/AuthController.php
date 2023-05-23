<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PersonalToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        $validasi = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:6',
        ]);

        if($validasi->fails()){
            return $this->error($validasi->errors()->first());
        }

        $user = User::where('email', $request->email)->with('userRole')->first();
        if($user){

            if(password_verify($request->password, $user->password)){
                $token = PersonalToken::create([
                    'token' => $this->generateToken(),
                    'userId' => $user->id
                ]);

                $user->token = $token->token;
                return $this->success($user);
            } else {
                return $this->error("Password anda salah");
            }
        }
        return $this->error('user tidak ditemukan');
    }

    public function register(Request $request){
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        if($validasi->fails()){
            return $this->error($validasi->errors()->first());
        }

        $user = User::create(array_merge($request->all(), [
            'password' => bcrypt($request->password)
        ]));

        if($user){
            return $this->success($user, 'selamat datang '.$user->name);
        } else {
            return $this->error("Terjadi Kesalahan");
        }
    }

    public function update(Request $request, $id){
        $user = User::where('id', $id)->first();
        if ($user) {
            $user->update($request->all());
            return $this->success($user);
        }

        return $this->error("tidak ada user");
    }

    public function upload(Request $request, $id) {
        $user = User::where('id', $id)->first();
        if($user){
            $fileName = "";
            if ($request->image){
                $image = $request->image->getClientOriginalName();
                $image = str_replace(' ', '', $image);
                $image = date('Hs') . rand(1, 999) . "_" . $image;
                $fileName = $image;
                $request->image->storeAs('public/user', $image);
            } else {
                return $this->error("Gambar wajib di kirim");
            }

            $user->update([
                'image' => $fileName
            ]);
            return $this->success($user);
        }
        return $this->error("user tidak ditemukan");
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
        //return response()->json([
          //  'ok' => false,
            //'error_code' => 400,
            //'description' => $message
        //], 400);
    }

    public function generateToken(): string {
        $alfabet = "abcdefghijklmnopqrstuvwxyz";
        $alfabetUpercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $numeric = "1234567890";
        $allCart = $alfabet . $alfabetUpercase . $numeric;
        return substr(str_shuffle($allCart), 0, 60);
    }
}
