<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommandeProduitRequest;
use App\Services\CommandeProduitService;
use Illuminate\Support\Facades\Gate;

class CommandeProduitController extends Controller
{
    protected $commandeProduitService;

    public function __construct(CommandeProduitService $commandeProduitService)
    {
        $this->commandeProduitService = $commandeProduitService;
        // Voir les commandes-produits
        $this->middleware(function ($request, $next) {
            if (Gate::denies('view-commande-produits')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['index', 'show']);

        // Créer une commande-produit (ADMIN, EMPLOYE, CLIENT)
        $this->middleware(function ($request, $next) {
            if (Gate::denies('create-commande-produits')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['store']);

        // Mettre à jour une commande-produit (ADMIN, EMPLOYE)
        $this->middleware(function ($request, $next) {
            if (Gate::denies('update-commande-produits')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['update']);

        // Supprimer une commande-produit (ADMIN)
        $this->middleware(function ($request, $next) {
            if (Gate::denies('delete-commande-produits')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['destroy']);
    }

    /**
     * Lister tous les enregistrements
     */
    public function index()
    {
        $items = $this->commandeProduitService->index();
        return response()->json($items, 200);
    }

    /**
     * Créer un nouvel enregistrement
     */
    public function store(CommandeProduitRequest $request)
    {
        $item = $this->commandeProduitService->store($request->validated());
        return response()->json($item, 201);
    }

    /**
     * Afficher un enregistrement
     */
    public function show(int $id)
    {
        $item = $this->commandeProduitService->show($id);
        return response()->json($item, 200);
    }

    /**
     * Mettre à jour un enregistrement
     */
    public function update(CommandeProduitRequest $request, int $id)
    {
        $item = $this->commandeProduitService->update($request->validated(), $id);
        return response()->json([
            "message" => "CommandeProduit modifié",
            "data" => $item
        ], 200);
    }

    /**
     * Supprimer un enregistrement
     */
    public function destroy(int $id)
    {
        $this->commandeProduitService->destroy($id);
        return response()->json("", 204);
    }
}
