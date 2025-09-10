<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatutcommandeRequest;
use Illuminate\Http\Request;
use App\Services\CommandeService;
use App\Http\Requests\CommandeRequest;
use Illuminate\Support\Facades\Gate;
class CommandeController extends Controller
{
    protected $commandeService;

    public function __construct(CommandeService $commandeService)
    {
        $this->commandeService = $commandeService;
        // Seul ADMIN et EMPLOYE peuvent mettre à jour une commande
        $this->middleware(function ($request, $next) {
            if ($request->isMethod('PUT') || $request->isMethod('PATCH')) {
                if (Gate::denies('update-commande')) {
                    return response()->json(['message' => 'Non autorisé'], 403);
                }
            }
            return $next($request);
        })->only(['update']);

        // Tout le monde (ADMIN, EMPLOYE, CLIENT) peut créer une commande
        $this->middleware(function ($request, $next) {
            if ($request->isMethod('POST')) {
                if (Gate::denies('create-commande')) {
                    return response()->json(['message' => 'Non autorisé'], 403);
                }
            }
            return $next($request);
        })->only(['store']);

        // ADMIN et EMPLOYE et CLIENT peuvent voir une commande
        $this->middleware(function ($request, $next) {
            if (Gate::denies('view-commande')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['index', 'show']);

        // Suppression — réservé à ADMIN
        $this->middleware(function ($request, $next) {
            if (Gate::denies('delete-commande')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['destroy']);
    }

    /**
     * Lister toutes les commandes
     */
    public function index()
    {
        $commandes = $this->commandeService->index();
        return response()->json($commandes, 200);
    }

    /**
     * Créer une nouvelle commande
     */
    public function store(CommandeRequest $request)
    {
        $commande = $this->commandeService->store($request->validated());
        return response()->json($commande, 201);
    }

    /**
     * Afficher une commande spécifique
     */
    public function show(int $id)
    {
        $commande = $this->commandeService->show($id);
        return response()->json($commande, 200);
    }

    /**
     * Mettre à jour une commande
     */
    public function update(CommandeRequest $request, int $id)
    {
        $commande = $this->commandeService->update($request->validated(), $id);

        return response()->json([
            "message" => "Commande mise à jour",
            "commande" => $commande
        ], 200);
    }

    /**
     * Supprimer une commande
     */
    public function destroy(int $id)
    {
        $this->commandeService->destroy($id);
        return response()->json("", 204);
    }
    /**
     * Modifier uniquement le statut d'une commande
     */
    public function updateStatut(StatutcommandeRequest $request, int $id)
    {
        $commande = $this->commandeService->updateStatut($id, $request->validated()['statut']);

        return response()->json([
            "message" => "Statut mis à jour",
            "commande" => $commande
        ], 200);
    }

}
