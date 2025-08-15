<?php

namespace App\Http\Controllers;
use App\Services\PackService;
use App\Http\Requests\PackRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PackController extends Controller
{
    protected $packService;

    public function __construct(PackService $packService)
    {
        $this->packService = $packService;
        $this->middleware(function ($request, $next) {
            if (Gate::denies('view-packs')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['index', 'show']);

        // Créer un pack (ADMIN)
        $this->middleware(function ($request, $next) {
            if (Gate::denies('create-packs')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['store']);

        // Mettre à jour un pack (ADMIN)
        $this->middleware(function ($request, $next) {
            if (Gate::denies('update-packs')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['update']);

        // Supprimer un pack (ADMIN)
        $this->middleware(function ($request, $next) {
            if (Gate::denies('delete-packs')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        })->only(['destroy']);
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
