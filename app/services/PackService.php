<?php

namespace App\services;
use App\Models\Pack;

class PackService
{
    /**
     * Lister tous les packs
     */
    public function index()
    {
        return Pack::all();
    }

    /**
     * Créer un nouveau pack
     */
    public function store(array $data)
    {
        return Pack::create($data);
    }

    /**
     * Afficher un pack spécifique
     */
    public function show(int $id)
    {
        return Pack::findOrFail($id);
    }

    /**
     * Mettre à jour un pack
     */
    public function update(array $data, int $id)
    {
        $pack = Pack::findOrFail($id);
        $pack->update($data);
        return $pack;
    }

    /**
     * Supprimer un pack
     */
    public function destroy(int $id)
    {
        Pack::destroy($id);
    }
}
