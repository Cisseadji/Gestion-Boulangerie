<?php

namespace App\services;

use App\Models\Chat_message;

class ChatMessageService
{
    public function index()
    {
        return Chat_message::all();
    }

    public function store(array $data)
    {
        $data['date_envoi'] = now();
        return Chat_message::create($data);
    }

    public function show(int $id)
    {
        return Chat_message::findOrFail($id);
    }

    public function update(array $data, int $id)
    {
        $message = Chat_message::findOrFail($id);
        $message->update($data);
        return $message;
    }

    public function destroy(int $id)
    {
        Chat_message::destroy($id);
    }

}
