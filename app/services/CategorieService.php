<?php

namespace App\services;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieService
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Categories = Categorie::all();
        return $Categories;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(array $request)
    {
        $Categories = Categorie::create($request);
        return $Categories;
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Categorie::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(array $data, int $id)
    {
        $categorie = Categorie::findOrFail($id);
        $categorie->update($data);
        return $categorie;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Categorie::destroy($id);
    }

}
