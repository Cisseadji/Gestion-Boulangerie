<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PackProduitRequest;
use App\Services\PackProduitService;
use Illuminate\Support\Facades\Gate;

class PackProduitController extends Controller
{
    protected $packProduitService;

    public function __construct(PackProduitService $packProduitService)
    {
        $this->packProduitService = $packProduitService;
        // Voir les packs-produits (ADMIN, EMPLOYE, CLIENT)
        $this->middleware(function ($request, $next) {
            if (Gate::denies('view-pack-produits')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['index', 'show']);

        // Créer un pack-produit (ADMIN)
        $this->middleware(function ($request, $next) {
            if (Gate::denies('create-pack-produits')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['store']);

        // Mettre à jour un pack-produit (ADMIN)
        $this->middleware(function ($request, $next) {
            if (Gate::denies('update-pack-produits')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['update']);

        // Supprimer un pack-produit (ADMIN)
        $this->middleware(function ($request, $next) {
            if (Gate::denies('delete-pack-produits')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['destroy']);
    }

    public function index()
    {
        $items = $this->packProduitService->index();
        return response()->json($items, 200);
    }

    public function store(PackProduitRequest $request)
    {
        $item = $this->packProduitService->store($request->validated());
        return response()->json($item, 201);
    }

    public function show(int $id)
    {
        $item = $this->packProduitService->show($id);
        return response()->json($item, 200);
    }

    public function update(PackProduitRequest $request, int $id)
    {
        $item = $this->packProduitService->update($request->validated(), $id);
        return response()->json([
            "message" => "PackProduit modifié",
            "data" => $item
        ], 200);
    }

    public function destroy(int $id)
    {
        $this->packProduitService->destroy($id);
        return response()->json("", 204);
    }
}
