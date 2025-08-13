<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\services\CategorieService;
use App\Http\Requests\CategorieRequest;

class CategorieController extends Controller
{
    protected $categorieService;

    public function __construct()
    {
        $this->CategorieService =new categorieService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorie = $this->CategorieService->index();
        return response()->json($categorie,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategorieRequest $request) // <-- ICI changement
    {
        $categorie = $this->CategorieService->store($request->validated());
        return response()->json($categorie, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categorie = $this->CategorieService->show($id);
        return response()->json($categorie,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategorieRequest  $request, string $id)
    {
        $categorie = $this->CategorieService->update($request->validated(), $id);

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
        $this->CategorieService->destroy($id);
        return response()->json("",204);
    }
}
