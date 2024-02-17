<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Usuario creado con éxito',
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ], 200);
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
    
        if (Auth::attempt($credentials)) {
            $authenticatedUser = Auth::user();
            $token = $authenticatedUser->createToken('token')->plainTextToken;
    
            // Obtener todos los usuarios
            $users = User::all();
    
            return response()->json([
                'status' => true,
                'message' => 'Usuario logeado con éxito',
                'data' => [
                    'user' => $authenticatedUser,
                    'users' => $users
                ],
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'errors' => 'Error con email o contraseña, credenciales inválidas'
            ], 401);
        }
    }

    public function userProfile(Request $request){
        return response()->json([
            "message" => "userProfile OK",
            "userData" => auth()->user()
        ], Response::HTTP_OK);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully'
        ],200);

    }

    public function allUsers(){
        $users = User::all();
        return response()->json([
            "users" => $users
        ]);
    }
}
