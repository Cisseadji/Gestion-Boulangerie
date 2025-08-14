<?php

namespace App\Http\Controllers;
use App\Services\PackService;
use App\Http\Requests\PackRequest;

use Illuminate\Http\Request;

class PackController extends Controller
{
    protected $packService;

    public function __construct(PackService $packService)
    {
        $this->packService = $packService;
    }

    public function index()
    {
        $packs = $this->packService->index();
        return response()->json($packs, 200);
    }

    public function store(PackRequest $request)
    {
        $pack = $this->packService->store($request->validated());
        return response()->json($pack, 201);
    }

    public function show(int $id)
    {
        $pack = $this->packService->show($id);
        return response()->json($pack, 200);
    }

    public function update(PackRequest $request, int $id)
    {
        $pack = $this->packService->update($request->validated(), $id);
        return response()->json([
            "message" => "Pack modifié",
            "pack" => $pack
        ], 200);
    }

    public function destroy(int $id)
    {
        $this->packService->destroy($id);
        return response()->json("", 204);
    }
}
