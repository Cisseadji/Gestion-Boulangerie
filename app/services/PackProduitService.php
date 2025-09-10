<?php

namespace App\services;


use App\Models\Pack_produit;

class PackProduitService
{
    public function index()
    {
        return Pack_produit::all();
    }

    public function store(array $data)
    {
        return Pack_produit::create($data);
    }

    public function show(int $id)
    {
        return Pack_produit::findOrFail($id);
    }

    public function update(array $data, int $id)
    {
        $packProduit = Pack_produit::findOrFail($id);
        $packProduit->update($data);
        return $packProduit;
    }

    public function destroy(int $id)
    {
        Pack_produit::destroy($id);
    }

}
