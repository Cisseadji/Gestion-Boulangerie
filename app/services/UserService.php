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
        $users = User::create($request);
        return $users;
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
        $users->update($data);
        return $users;
    }

}
