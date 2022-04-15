<?php declare(strict_types=1);

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
        $value = 0;
        foreach($this->messages as $message)
        {
            if($message['type'] === $type)
            {

                $value++;

            }
        }

        return $value;
    }

}