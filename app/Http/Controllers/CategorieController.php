<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\services\CategorieService;
use App\Http\Requests\CategorieRequest;
use Illuminate\Support\Facades\Gate;

class CategorieController extends Controller
{
    protected $categorieService;

    public function __construct()
    {
        $this->categorieService =new categorieService();
        // Autorisation pour création
        $this->middleware(function ($request, $next) {
            if (Gate::denies('create-categories')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['store']);

        // Autorisation pour mise à jour
        $this->middleware(function ($request, $next) {
            if (Gate::denies('update-categories')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['update']);

        // Autorisation pour suppression
        $this->middleware(function ($request, $next) {
            if (Gate::denies('delete-categories')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorie = $this->categorieService->index();
        return response()->json($categorie,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategorieRequest $request) // <-- ICI changement
    {
        $categorie = $this->categorieService->store($request->validated());
        return response()->json($categorie, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categorie = $this->categorieService->show($id);
        return response()->json($categorie,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategorieRequest  $request, string $id)
    {
        $categorie = $this->categorieService->update($request->validated(), $id);

        return response()->json([
            "message" => "Offre modifiée",
            "categorie" => $categorie
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->categorieService->destroy($id);
        return response()->json("",204);
    }
}
