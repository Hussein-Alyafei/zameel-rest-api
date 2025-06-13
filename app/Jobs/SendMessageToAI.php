<?php

namespace App\Jobs;

use App\AI\ZameelAssistant;
use App\Events\AssistantResponded;
use App\Models\AssistantChat;
use App\Models\Book;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;

class SendMessageToAI implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private AssistantChat $chat, private array $message, private User $user) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $text = $this->message['message'];
        
        $messageToSend = [];
            if (is_null($this->chat->messages)) {
                $systemMessage = (new ZameelAssistant())->getSystemPrompt($this->user);
                $messageToSend = array_merge($messageToSend, [['role' => 'system', 'content' => $systemMessage]]);
            }
        
        $messageToSend = array_merge($messageToSend, [['role' => 'user', 'content' => $text]]);
        $messages = array_merge(($this->chat->messages ?? []), $messageToSend);

        $result = OpenAI::chat()->create([
            'model' => config('openai.chat_model'),
            'messages' => $messages,
        ]);

        $messages = array_merge($messages, [['role' => 'assistant', 'content' => $result->choices[0]->message->content]]);
        $this->chat->messages = $messages;
        $this->chat->save();

        AssistantResponded::dispatch($this->chat, $result->choices[0]->message->content);
    }
}
