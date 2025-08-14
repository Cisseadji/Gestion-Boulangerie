<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PackProduitRequest;
use App\Services\PackProduitService;
class PackProduitController extends Controller
{
    protected $packProduitService;

    public function __construct(PackProduitService $packProduitService)
    {
        $this->packProduitService = $packProduitService;
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
