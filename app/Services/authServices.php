<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
class authServices
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function registerUser(array $data)
    {
        $role = $data['role'] ?? 'user';

        if ($role !== 'user') {
            Gate::authorize('create-user-with-role');
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,
        ]);

        
}
}