<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FactureService;
use App\Http\Requests\FactureRequest;

class FacturesController extends Controller
{
    protected $factureService;

    public function __construct(FactureService $factureService)
    {
        $this->factureService = $factureService;
    }

    public function index()
    {
        return response()->json($this->factureService->index(), 200);
    }

    public function store(FactureRequest $request)
    {
        $facture = $this->factureService->store($request->validated());
        return response()->json($facture, 201);
    }

    public function show(int $id)
    {
        $facture = $this->factureService->show($id);
        return response()->json($facture, 200);
    }

    public function update(FactureRequest $request, int $id)
    {
        $facture = $this->factureService->update($request->validated(), $id);
        return response()->json([
            'message' => 'Facture modifiée',
            'facture' => $facture
        ], 200);
    }

    public function destroy(int $id)
    {
        $this->factureService->destroy($id);
        return response()->json('', 204);
    }
}
