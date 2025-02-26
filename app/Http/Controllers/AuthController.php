<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function hello()
    {
        return response()->json(['message' => 'Hello!']);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email','password'))){
             /**@var User $user */
            $user = Auth::user();
            $token=$user->createToken('app')->accessToken;

            return response([
                'message'=>'success',
                'token'=>$token,
                'user'=>$user
            ]);
            // print($token,'token');
        }

        return response()->json([
            'message' => 'Invalid username/password'
        ], 401);
    }
}
