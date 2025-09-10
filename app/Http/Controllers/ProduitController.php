<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProduitRequest;
use Illuminate\Http\Request;
use App\Services\ProduitService;
use Illuminate\Support\Facades\Gate;

class ProduitController extends Controller
{
    protected $produitService;

    public function __construct(ProduitService $produitService)
    {

        $this->produitService = $produitService;
        // Autorisation pour création
        $this->middleware(function ($request, $next) {
            if (Gate::denies('create-produits')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['store']);

        // Autorisation pour mise à jour
        $this->middleware(function ($request, $next) {
            if (Gate::denies('update-produits')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['update']);

        // Autorisation pour suppression
        $this->middleware(function ($request, $next) {
            if (Gate::denies('delete-produits')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['destroy']);
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
        $this->middleware(function ($request, $next) {
            if (Gate::denies('manage-produits')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        });
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
