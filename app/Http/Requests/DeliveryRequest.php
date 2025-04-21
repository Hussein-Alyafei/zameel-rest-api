<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Orion\Http\Requests\Request;

class DeliveryRequest extends Request
{
    private $deliverytypes = ['url', 'text', 'file'];

    private $fileTypes = ['pdf', 'zip', 'rar', 'docx', 'pptx', 'ppt', 'psd', 'mpp', 'ai', 'm', 'mat', 'ino', 'h'];

    public function storeRules(): array
    {
        return [
            'type' => ['required', Rule::in($this->deliverytypes)],
            'content' => $this->getContentRules($this->input('type')),
            'assignment_id' => 'required|integer|exists:assignments,id',
        ];
    }

    private function getContentRules($type): array
    {
        return match ($type) {
            'url' => ['required', 'url'],
            'text' => ['required', 'string'],
            'file' => ['required', File::types($this->fileTypes)->max(50 * 1024)],
        };
    }
}
