<?php


use App\Models\chat_message;


class ChatMessageService
{
    public function index($userId)
    {
        return chat_message::with(['expediteur', 'destinataire'])
            ->where('id_expediteur', $userId)
            ->orWhere('id_destinataire', $userId)
            ->orderBy('date_envoi', 'asc')
            ->get();
    }

    public function store(array $data, $userId)
    {
        $data['id_expediteur'] = $userId;
        $data['date_envoi'] = now();
        return chat_message::create($data);
    }

    public function markAsRead(int $id)
    {
        $message = chat_message::findOrFail($id);
        $message->lu = true;
        $message->save();
        return $message;
    }
}
