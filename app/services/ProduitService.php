<?php

namespace App\Services;

use App\Models\Produit;
use Illuminate\Support\Facades\Storage;

class ProduitService
{
    /**
     * Lister tous les produits
     */
    public function index()
    {
        return Produit::all();
    }

    /**
     * Créer un nouveau produit
     */
    public function store(array $data)
    {
        // ✅ Vérifier si un fichier est uploadé
        if (request()->hasFile('image_url')) {
            $data['image_url'] = request()->file('image_url')->store('produits', 'public');
        }

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

        // ✅ Si une nouvelle image est envoyée
        if (request()->hasFile('image_url')) {
            // Supprimer l'ancienne si elle existe
            if ($produit->image_url && Storage::disk('public')->exists($produit->image_url)) {
                Storage::disk('public')->delete($produit->image_url);
            }

            // Enregistrer la nouvelle
            $data['image_url'] = request()->file('image_url')->store('produits', 'public');
        }

        $produit->update($data);
        return $produit;
    }

    /**
     * Supprimer un produit
     */
    public function destroy(int $id)
    {
        $produit = Produit::findOrFail($id);

        if ($produit->image_url && Storage::disk('public')->exists($produit->image_url)) {
            Storage::disk('public')->delete($produit->image_url);
        }

        $produit->delete();
    }
}
