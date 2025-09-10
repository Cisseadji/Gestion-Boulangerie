<?php

namespace App\services;

use App\Models\User;

class UserService
{
    public function index()
    {
        $users = User::all();
        return $users;
    }

    public function store(array $request)
    {
        $user = User::create([
            'nom' => $request['nom'],
            'prenom' => $request['prenom'],
            'email' => $request['email'],
            'telephone' => $request['telephone'],
            'password' => bcrypt($request['password']),
            'role' => $request['role'],
            'actif' => true,
        ]);

        return $user;
    }

    public function destroy(int $id)
    {
        User::destroy($id);
    }
    public function show($id)
    {
        return User::find($id);

    }


    public function update(array $data, $id)
    {
        $users = User::findOrFail($id);
        // ⚡ On enlève le password si vide
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            // Si password présent → on le hash
            $data['password'] = bcrypt($data['password']);
        }

        $users->update($data);

        return $users;

    }

}
