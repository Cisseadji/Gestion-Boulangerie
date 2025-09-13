<?php

namespace App\services;
use App\Models\Commande;
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
        if (!isset($data['id_client']) && isset($data['id_commande'])) {
            $commande = Commande::findOrFail($data['id_commande']);
            $data['id_client'] = $commande->id_client; // ⚡ utiliser le client de la commande
        }

        return Livraison::create($data);
    }




    public function createFromCommande(array $data)
    {
        // Vérifier que la commande existe et qu'elle est PRETE
        $commande = Commande::findOrFail($data['id_commande']);
        if ($commande->statut !== 'PRETE') {
            throw new \Exception('La commande n\'est pas prête pour livraison.');
        }

        // Créer la livraison
        $livraison = Livraison::create([
            'id_commande' => $commande->id,
            'id_client'   => $commande->id_client, // ⚡ ajouter ici
            'adresse'     => $commande->adresse,
            'date_prevue' => now()->addDays(2),
            'statut'      => 'EN_COURS'
        ]);


        // Mettre à jour le statut de la commande
        $commande->statut = 'EN_LIVRAISON';
        $commande->save();

        return $livraison;
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

    public function updateStatut(int $id, string $statut)
    {
        $livraison = Livraison::findOrFail($id);
        $livraison->update(['statut' => $statut]); // updated_at auto

        // 🔔 Notifier le client par événement (mail, notification, etc.)
        event(new \App\Events\LivraisonStatutUpdated($livraison));

        return $livraison;
    }

}
