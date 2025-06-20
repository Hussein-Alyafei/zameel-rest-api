<?php

namespace App\Jobs;

use App\AI\ZameelAssistant;
use App\Events\AssistantResponded;
use App\Models\AssistantChat;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Str;
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

        $threadId = $this->chat->thread_id;
        $assistantId = config('openai.assistant_key');

        if (is_null($threadId)) {
            $systemMessage = (new ZameelAssistant)->getSystemPrompt($this->user, $this->chat->books ?? []);
            $thread = OpenAI::threads()->create([
                'messages' => [['role' => 'user', 'content' => $systemMessage]],
            ]);
            $threadId = $thread->id;
        }

        OpenAI::threads()->messages()->create($threadId, [
            'role' => 'user',
            'content' => $text,
        ]);

        $run = OpenAI::threads()->runs()->create($threadId, [
            'assistant_id' => $assistantId,
        ]);

        do {
            sleep(0.3);
            $runStatus = OpenAI::threads()->runs()->retrieve($threadId, $run->id);
        } while ($runStatus->status !== 'completed');

        $messages = OpenAI::threads()->messages()->list($threadId);

        $lastMessage = collect($messages->data)->firstWhere('role', 'assistant');

        $response = $lastMessage?->content[0]?->text?->value;

        $chunks = Str::of($response)->matchAll('/.{1,1024}/us')->toArray();
        $uuid = Str::uuid()->toString();
        for ($i = 0; $i < count($chunks); $i++) {
            AssistantResponded::dispatch($this->chat, $uuid, $i, $chunks[$i]);
        }
    }
}
