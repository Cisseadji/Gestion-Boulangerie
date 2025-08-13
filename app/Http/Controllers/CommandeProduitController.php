<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommandeProduitRequest;
use App\Services\CommandeProduitService;
class CommandeProduitController extends Controller
{
    protected $commandeProduitService;

    public function __construct(CommandeProduitService $commandeProduitService)
    {
        $this->commandeProduitService = $commandeProduitService;
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
