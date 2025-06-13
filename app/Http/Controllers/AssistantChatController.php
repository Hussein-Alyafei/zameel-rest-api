<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssistantChatRequest;
use App\Jobs\SendMessageToAI;
use App\Models\AssistantChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssistantChatController extends Controller
{
    public function store(Request $request)
    {
        $chat = AssistantChat::create();

        return response()->json(['date' => ['id' => $chat->id]]);
    }

    public function update(AssistantChatRequest $request, AssistantChat $chat)
    {
        $message = $request->validated();

        SendMessageToAI::dispatch($chat, $message, Auth::user());

        return response()->json(['message' => 'ok'], 202);
    }
}
