<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller















{




public function ambil(request $request){
    $data = User::all();



    return response()->json([
        'message' => 'berhasil',
        'data' => $data,




    ]);




}








    //
  public function register(Request $request) {
  $data = $request->all();
  $validator = Validator::make($data, [
  'name' => 'required|string|max:255',
  'email' => 'required|email|unique:users,email',
  'password' => 'required|string|min:6',
  'role' => 'required|in:user,admin,driver', // Role harus ditentukan
  'phone' => 'required|numeric',
  ]);

  if ($validator->fails()) {
  return response()->json([
  'message' => 'Validasi gagal',
  'errors' => $validator->errors(),
  ], 422);
  }

  // Generate ID user
  $data['id_user'] = 'USR' . time() . mt_rand(10, 99);
  $data['password'] = Hash::make($data['password']); // ✅ Hash password sebelum menyimpan

  // Simpan user
  $user = new User();
  $user->fill($data);
  $user->save();

  // Buat token
  $token = $user->createToken('auth_token')->plainTextToken;

  return response()->json([
  'message' => 'Register berhasil',
  'data' => $user,
  'token' => $token
  ]);
  }


public function login(Request $request)
{
    $data = $request->all();
    $validator = Validator::make($data, [
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validasi gagal',
            'errors' => $validator->errors(),
        ], 422);
    }



    $user = User::where('email', $data['email'])->first();
    if (!$user || !Hash::check($data['password'], $user->password)) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

$token = $user->createToken($user->role)->plainTextToken;

return response()->json([
'message' => 'Login berhasil',
'data' => $user,
'token' => $token
]);

// return "berahasil";


}



public function logout(Request $request)
{
    $request->user()->tokens()->delete();

    return response()->json([
        'message' => 'Logout berhasil'
    ]);
}
}
