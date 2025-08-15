<?php

namespace App\services;

use App\Models\Commande;

class CommandeService
{
    /**
     * Lister toutes les commandes
     */
    public function index()
    {
        $Commande = Commande::all();
        return $Commande;
    }

    /**
     * Créer une nouvelle commande
     */
    public function store(array $data)
    {
        return Commande::create($data);
    }

    /**
     * Afficher une commande spécifique
     */
    public function show(int $id)
    {
        return Commande::findOrFail($id);
    }

    /**
     * Mettre à jour une commande
     */
    public function update(array $data, int $id)
    {
        $commande = Commande::findOrFail($id);
        $commande->update($data);
        return $commande;
    }

    /**
     * Supprimer une commande
     */
    public function destroy(int $id)
    {
        Commande::destroy($id);
    }

    /**
     * Mettre à jour uniquement le statut d'une commande
     */

    public function updateStatut(int $id, string $statut)
    {
        $commande = Commande::findOrFail($id);
        $commande->update(['statut' => $statut]); // updated_at sera mis à jour
        return $commande;
    }



}
