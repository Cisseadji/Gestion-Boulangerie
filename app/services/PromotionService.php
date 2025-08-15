<?php

namespace App\services;
use App\Models\Promotion;

class PromotionService
{
    public function index()
    {
        return Promotion::all();
    }

    /**
     * Créer une promotion
     */
    public function store(array $data)
    {
        return Promotion::create($data);
    }

    /**
     * Afficher une promotion
     */
    public function show(int $id)
    {
        return Promotion::findOrFail($id);
    }

    /**
     * Mettre à jour une promotion
     */
    public function update(array $data, int $id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->update($data);
        return $promotion;
    }

    /**
     * Supprimer une promotion
     */
    public function destroy(int $id)
    {
        Promotion::destroy($id);
    }
    public function toggleActif(int $id, bool $actif)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->update(['actif' => $actif]);
        return $promotion;
    }

}
