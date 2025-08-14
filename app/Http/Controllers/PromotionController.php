<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PromotionService;
use App\Http\Requests\PromotionRequest;

class PromotionController extends Controller
{
    protected $promotionService;

    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
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
}
