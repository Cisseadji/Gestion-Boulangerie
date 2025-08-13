<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProduitRequest;
use Illuminate\Http\Request;
use App\Services\ProduitService;

class ProduitController extends Controller
{
    protected $produitService;

    public function __construct(ProduitService $produitService)
    {
        $this->produitService = $produitService;
    }

    /**
     * Lister tous les produits
     */
    public function index()
    {
        $produits = $this->produitService->index();
        return response()->json($produits, 200);
    }

    /**
     * Créer un produit
     */
    public function store(ProduitRequest $request)
    {
        $produit = $this->produitService->store($request->validated());
        return response()->json($produit, 201);
    }

    /**
     * Afficher un produit
     */
    public function show(int $id)
    {
        $produit = $this->produitService->show($id);
        return response()->json($produit, 200);
    }

    /**
     * Mettre à jour un produit
     */
    public function update(ProduitRequest $request, int $id)
    {
        $produit = $this->produitService->update($request->validated(), $id);
        return response()->json([
            "message" => "Produit modifié",
            "produit" => $produit
        ], 200);
    }

    /**
     * Supprimer un produit
     */
    public function destroy(int $id)
    {
        $this->produitService->destroy($id);
        return response()->json("", 204);
    }
}
