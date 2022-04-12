<?php

namespace App\Util;

class MessageManager
{

    private array $messages = [];

    public function add(string $type, string $text): void
    {

        $this->messages[] = ['type' => $type, 'text' => $text];

    }

    public function getMessageArray(): array
    {

        return $this->messages;

    }

    public function countType(string $type): int
    {

        return isset($this->messages[$type]) ? count($this->messages[$type]) : 0;

    }

}