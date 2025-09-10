<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $request)
    {
        $user = User::create([
            'nom' => $request['nom'],
            'prenom' => $request['prenom'],
            'email' => $request['email'],
            'telephone' => $request['telephone'],
            'password' => bcrypt($request['password']),
            'role' => 'CLIENT',
            'actif' => true,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];
    }

    public function login(array $request)
    {
        $user = User::where('email', $request['email'])->first();

        // Cas 1 : email introuvable
        if (!$user) {
            return 'not_found';
        }

        // Cas 2 : mauvais mot de passe
        if (!Hash::check($request['password'], $user->password)) {
            return 'wrong_password';
        }

        // Cas 3 : compte désactivé
        if (!$user->actif) {
            return 'inactive';
        }

        // Cas 4 : succès → génération du token
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];
    }


    public function logout(User $user)
    {
        $user->tokens()->delete();
        return true;
    }
}
