<?php

namespace App\Services;

use App\Models\Commande;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommandeService
{
    public function index()
    {
        return Commande::with(['produits', 'client'])->get();
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            $commande = Commande::create([
                'id_client'     => Auth::id(),
                'total'         => $data['total'],
                'statut'        => $data['statut'] ?? 'EN_PREPARATION',
                'mode_paiement' => $data['mode_paiement'],
                'adresse'       => $data['adresse'],
                'date_commande' => $data['date_commande'] ?? now(),
            ]);

            if (!empty($data['produits']) && is_array($data['produits'])) {
                $syncData = [];
                foreach ($data['produits'] as $produit) {
                    $syncData[$produit['id']] = [
                        'quantite' => $produit['quantite'],
                        'prix_unitaire' => $produit['prix_unitaire']
                    ];
                }
                $commande->produits()->sync($syncData);
            }

            return $commande->load('produits');
        });
    }

    public function show(int $id)
    {
        return Commande::with(['produits', 'client'])->findOrFail($id);
    }

    public function update(array $data, int $id)
    {
        $commande = Commande::findOrFail($id);
        $commande->update($data);

        if (!empty($data['produits']) && is_array($data['produits'])) {
            $syncData = [];
            foreach ($data['produits'] as $produit) {
                $syncData[$produit['id']] = [
                    'quantite' => $produit['quantite'],
                    'prix_unitaire' => $produit['prix_unitaire']
                ];
            }
            $commande->produits()->sync($syncData);
        }

        return $commande->load('produits');
    }

    public function destroy(int $id)
    {
        $commande = Commande::findOrFail($id);
        $commande->delete();
    }

    public function updateStatut(int $id, string $statut)
    {
        $commande = Commande::findOrFail($id);
        $commande->update(['statut' => $statut]);
        return $commande;
    }
}
