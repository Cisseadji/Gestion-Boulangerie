<?php

namespace App\services;
use App\Models\Facture;

class FactureService
{
    public function index()
    {
        return Facture::all();
    }

    public function store(array $data)
    {
        return Facture::create($data);
    }

    public function show(int $id)
    {
        return Facture::findOrFail($id);
    }

    public function update(array $data, int $id)
    {
        $facture = Facture::findOrFail($id);
        $facture->update($data);
        return $facture;
    }

    public function destroy(int $id)
    {
        Facture::destroy($id);
    }

}
