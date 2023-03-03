<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validateData = $request->validate([
             'name' => 'required|max:12',
             'email' => 'email|required|unique:users',
             'password' => 'required|confirmed'
        ]);

        $validateData['password'] = Hash::make($request->password);

        $user = User::create($validateData);

        $accesToken = $user->createToken('authToken')->accesToken;

        return response(['user'=> $user, 'acces_token'=> $accesToken], 201);
    } 
    
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) { 
            return response(['message' => 'user ini tidak terdaftar, silahkan cek kembali!'], 400);
        }

        $accesToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user'=>auth()->user(), 'acces_token'=> $accesToken]);

    }
}
