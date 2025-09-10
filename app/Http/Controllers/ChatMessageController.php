<?php
namespace App\Http\Controllers;

namespace App\Http\Controllers;


use App\Http\Requests\ChatMessageequest;
use ChatMessageService;
use Illuminate\Support\Facades\Auth;
use App\Events\NewChatMessage;

class ChatMessageController extends Controller
{
    protected $chatMessageService;

    public function __construct(ChatMessageService $chatMessageService)
    {
        $this->chatMessageService = $chatMessageService;
    }

    public function index()
    {
        return response()->json(
            $this->chatMessageService->index(Auth::id()),
            200
        );
    }

    public function store(ChatMessageequest $request)
    {
        $message = $this->chatMessageService->store($request->validated(), Auth::id());

        // 🔔 Diffusion en temps réel
        event(new NewChatMessage($message));

        return response()->json($message, 201);
    }

    public function markAsRead(int $id)
    {
        $message = $this->chatMessageService->markAsRead($id);
        return response()->json($message, 200);
    }
}
