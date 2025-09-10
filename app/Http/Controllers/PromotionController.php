<?php

namespace App\Http\Controllers;

use App\Http\Requests\TogglePromotionRequest;
use Illuminate\Http\Request;
use App\Services\PromotionService;
use App\Http\Requests\PromotionRequest;
use Illuminate\Support\Facades\Gate;

class PromotionController extends Controller
{
    protected $promotionService;

    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
        // Voir les promotions (ADMIN, EMPLOYE, CLIENT)
        $this->middleware(function ($request, $next) {
            if (Gate::denies('view-promotion')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['index', 'show']);

        // Créer une promotion (ADMIN)
        $this->middleware(function ($request, $next) {
            if (Gate::denies('create-promotion')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['store']);

        // Mettre à jour une promotion (ADMIN)
        $this->middleware(function ($request, $next) {
            if (Gate::denies('update-promotion')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['update']);

        // Supprimer une promotion (ADMIN)
        $this->middleware(function ($request, $next) {
            if (Gate::denies('delete-promotion')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['destroy']);

        // Activer ou désactiver une promotion (ADMIN)
        $this->middleware(function ($request, $next) {
            if (Gate::denies('activate-promotion')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['toggleActif']);
    }

    /**
     * Lister toutes les promotions
     */
    public function index()
    {
        $promotions = $this->promotionService->index();
        return response()->json($promotions, 200);
    }

    /**
     * Créer une promotion
     */
    public function store(PromotionRequest $request)
    {
        $promotion = $this->promotionService->store($request->validated());
        return response()->json($promotion, 201);
    }

    /**
     * Afficher une promotion
     */
    public function show(int $id)
    {
        $promotion = $this->promotionService->show($id);
        return response()->json($promotion, 200);
    }

    /**
     * Mettre à jour une promotion
     */
    public function update(PromotionRequest $request, int $id)
    {
        $promotion = $this->promotionService->update($request->validated(), $id);
        return response()->json([
            'message' => 'Promotion modifiée',
            'promotion' => $promotion
        ], 200);
    }

    /**
     * Supprimer une promotion
     */
    public function destroy(int $id)
    {
        $this->promotionService->destroy($id);
        return response()->json('', 204);
    }
    public function toggleActif(TogglePromotionRequest $request, int $id)
    {
        $promotion = $this->promotionService->toggleActif($id, $request->validated()['actif']);

        return response()->json([
            'message' => $promotion->actif ? 'Promotion activée' : 'Promotion désactivée',
            'promotion' => $promotion
        ], 200);
    }


}
