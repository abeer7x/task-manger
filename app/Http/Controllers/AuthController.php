<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class AuthController extends Controller
{
   
    
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:40',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed|string',
            'role' => 'nullable|string'
        ]);
    
        $role = $validated['role'] ?? 'user';
    
        if ($role !== 'user') {
            Gate::authorize('create-user-with-role');
        }
    
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
        ]);
    
        return $this->success(['user' => $user, 'message' => 'User registered successfully'], 201);
    }

    public function login(Request $request)
    {
      $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string'
    ]);

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'message' => 'Invalid email or password'
        ], 401);
    }

    $user = User::where('email', $request->email)->firstOrFail();
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'User login successful',
        'user' => $user,
        'token' => $token
    ], 200);
    }
    

   


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(['message' => 'Logged out']);
}
}