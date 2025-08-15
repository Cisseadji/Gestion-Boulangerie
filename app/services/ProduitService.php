<?php

namespace App\services;

use App\Models\Produit;

class ProduitService
{
    /**
     * Lister tous les produits
     */
    public function index()
    {
        $Produit = Produit::all();
        return $Produit;
    }

    /**
     * Créer un nouveau produit
     */
    public function store(array $data)
    {
        return Produit::create($data);
    }

    /**
     * Afficher un produit spécifique
     */
    public function show(int $id)
    {
        return Produit::findOrFail($id);
    }

    /**
     * Mettre à jour un produit
     */
    public function update(array $data, int $id)
    {
        $produit = Produit::findOrFail($id);
        $produit->update($data);
        return $produit;
    }

    /**
     * Supprimer un produit
     */
    public function destroy(int $id)
    {
        Produit::destroy($id);
    }



}
