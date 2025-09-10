<?php

namespace App\Services;
use App\Models\Promotion;

class PromotionService
{
    public function index() {
        return Promotion::with('produits')->get();
    }

    public function store(array $data) {
        $produits = $data['produits'] ?? [];
        unset($data['produits']);

        $promotion = Promotion::create($data);
        if (!empty($produits)) {
            $promotion->produits()->sync($produits);
        }

        return $promotion->load('produits');
    }

    public function show(int $id) {
        return Promotion::with('produits')->findOrFail($id);
    }

    public function update(array $data, int $id) {
        $produits = $data['produits'] ?? [];
        unset($data['produits']);

        $promotion = Promotion::findOrFail($id);
        $promotion->update($data);

        if (!empty($produits)) {
            $promotion->produits()->sync($produits);
        }

        return $promotion->load('produits');
    }

    public function destroy(int $id) {
        Promotion::destroy($id);
    }

    public function toggleActif(int $id, bool $actif) {
        $promotion = Promotion::findOrFail($id);
        $promotion->update(['actif' => $actif]);
        return $promotion->load('produits');
    }
}
