<?php

namespace App\Livewire;

use Livewire\Component;

class SupportChat extends Component
{
    public array $messages =[];
    public string $input ='';
    public ?string $conversationId = null;

    public bool $isStreaming = false;

    public function render()
    {
        return view('livewire.support-chat');
    }
}
