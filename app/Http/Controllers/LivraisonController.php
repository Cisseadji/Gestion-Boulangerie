<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatutLivraisonRequest;
use App\Models\Commande;
use App\Models\Livraison;
use Illuminate\Http\Request;
use App\Services\LivraisonService;
use App\Http\Requests\LivraisonRequest;
use Illuminate\Support\Facades\Gate;

class LivraisonController extends Controller
{
    protected $livraisonService;

    public function __construct(LivraisonService $livraisonService)
    {
        $this->livraisonService = $livraisonService;
        // Voir livraison (ADMIN, EMPLOYE, CLIENT)
        $this->middleware(function ($request, $next) {
            if (Gate::denies('view-livraison')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['index', 'show']);

        // Mettre à jour livraison (ADMIN, EMPLOYE)
        $this->middleware(function ($request, $next) {
            if (Gate::denies('update-livraison')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['update']);
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
    public function updateStatut(StatutLivraisonRequest $request, int $id)
    {
        $livraison = $this->livraisonService->updateStatut($id, $request->validated()['statut']);

        return response()->json([
            "message" => "Statut mis à jour",
            "commande" => $livraison
        ], 200);
    }


    public function storeFromCommande(Request $request)
    {
        $livraison = $this->livraisonService->createFromCommande($request->all());

        return response()->json([
            'message' => 'Livraison créée automatiquement',
            'livraison' => $livraison
        ], 201);
    }






}
