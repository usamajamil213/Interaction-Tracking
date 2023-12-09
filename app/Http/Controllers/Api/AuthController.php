<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SigninRequest;
use App\Http\Requests\Api\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public  function login(SigninRequest $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([ 'token' => $token,'user' => $user,], 200);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }
    public  function signup(SignupRequest $request){

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' =>  Hash::make($request->password),
        ]);
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([ 'token' => $token,'user' => $user], 201);
    }
}
