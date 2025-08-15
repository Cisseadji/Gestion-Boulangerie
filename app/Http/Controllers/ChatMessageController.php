<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatMessageequest;
use App\services\ChatMessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ChatMessageController extends Controller
{
    protected $chatMessageService;

    public function __construct(ChatMessageService $chatMessageService)
    {
        $this->chatMessageService = $chatMessageService;
        $this->middleware(function ($request, $next) {
            if (Gate::denies('use-chat')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        });
    }

    public function index()
    {
        return response()->json($this->chatMessageService->index(), 200);
    }

    public function store(ChatMessageequest $request)
    {
        $message = $this->chatMessageService->store($request->validated());
        return response()->json($message, 201);
    }

    public function show(int $id)
    {
        return response()->json($this->chatMessageService->show($id), 200);
    }

    public function update(ChatMessageequest $request, int $id)
    {
        $message = $this->chatMessageService->update($request->validated(), $id);
        return response()->json([
            'message' => 'Message modifié',
            'data' => $message
        ], 200);
    }

    public function destroy(int $id)
    {
        $this->chatMessageService->destroy($id);
        return response()->json('', 204);
    }
}
