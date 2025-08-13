<?php

namespace App\services;

use App\Models\Commande_produit;

class CommandeProduitService
{
    /**
     * Lister tous les enregistrements
     */
    public function index()
    {
        $CommandeProduit = Commande_produit::all();
        return $CommandeProduit;
    }

    /**
     * Créer un nouvel enregistrement
     */
    public function store(array $data)
    {
        return Commande_produit::create($data);
    }

    /**
     * Afficher un enregistrement spécifique
     */
    public function show(int $id)
    {
        return Commande_produit::findOrFail($id);
    }

    /**
     * Mettre à jour un enregistrement
     */
    public function update(array $data, int $id)
    {
        $commandeProduit = Commande_produit::findOrFail($id);
        $commandeProduit->update($data);
        return $commandeProduit;
    }

    /**
     * Supprimer un enregistrement
     */
    public function destroy(int $id)
    {
        Commande_produit::destroy($id);
    }

}
