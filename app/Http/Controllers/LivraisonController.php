<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LivraisonService;
use App\Http\Requests\LivraisonRequest;

class LivraisonController extends Controller
{
    protected $livraisonService;

    public function __construct(LivraisonService $livraisonService)
    {
        $this->livraisonService = $livraisonService;
    }

    /**
     * Lister toutes les livraisons
     */
    public function index()
    {
        $livraisons = $this->livraisonService->index();
        return response()->json($livraisons, 200);
    }

    /**
     * Créer une livraison
     */
    public function store(LivraisonRequest $request)
    {
        $livraison = $this->livraisonService->store($request->validated());
        return response()->json($livraison, 201);
    }

    /**
     * Afficher une livraison
     */
    public function show(int $id)
    {
        $livraison = $this->livraisonService->show($id);
        return response()->json($livraison, 200);
    }

    /**
     * Mettre à jour une livraison
     */
    public function update(LivraisonRequest $request, int $id)
    {
        $livraison = $this->livraisonService->update($request->validated(), $id);
        return response()->json([
            "message" => "Livraison modifiée",
            "livraison" => $livraison
        ], 200);
    }

    /**
     * Supprimer une livraison
     */
    public function destroy(int $id)
    {
        $this->livraisonService->destroy($id);
        return response()->json("", 204);
    }
}
