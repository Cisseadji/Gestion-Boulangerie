<?php

namespace App\services;
use App\Models\Livraison;

class LivraisonService
{
    /**
     * Lister toutes les livraisons
     */
    public function index()
    {
        $Livraison = Livraison::all();
        return $Livraison;
    }

    /**
     * Créer une nouvelle livraison
     */
    public function store(array $data)
    {
        return Livraison::create($data);
    }

    /**
     * Afficher une livraison spécifique
     */
    public function show(int $id)
    {
        return Livraison::findOrFail($id);
    }

    /**
     * Mettre à jour une livraison
     */
    public function update(array $data, int $id)
    {
        $livraison = Livraison::findOrFail($id);
        $livraison->update($data);
        return $livraison;
    }

    /**
     * Supprimer une livraison
     */
    public function destroy(int $id)
    {
        Livraison::destroy($id);
    }

}
