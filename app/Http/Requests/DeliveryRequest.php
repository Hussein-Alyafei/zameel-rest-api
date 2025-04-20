<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rule;
use Orion\Http\Requests\Request;

class DeliveryRequest extends Request
{
    private $deliverytypes = ['url', 'text', 'file'];
    private $fileTypes = ['pdf', 'zip', 'rar', 'docx', 'pptx', 'ppt', 'psd', 'mpp', 'ai', 'm', 'mat', 'ino', 'h'];

    public function storeRules(): array
    {
        return [
            'type' => ['required', Rule::in($this->deliverytypes)],
            'content' => $this->getContentRule(),
            'assignment_id' => 'required|integer|exists:assignments,id',
            'student_id' => 'required|integer|exists:users,id',
        ];
    }

    private function getContentRule(): array
    {
        $type = $this->input('type');

        return match ($type) {
            'url' => ['required', 'url'],
            'text' => ['required', 'string'],
            'file' => ['required', File::types($this->fileTypes)->max(50 * 1024)],
        };
    }
}
