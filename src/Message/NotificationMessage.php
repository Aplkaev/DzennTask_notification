<?php

namespace App\Message;

class NotificationMessage
{
    public function __construct(
        public string $type,
        public string $name,
        public array $payload,
        public string $userId
    )
    {
    }

    public function __toString(): string
    {
        return json_encode([
            'type' => $this->type,
            'name' => $this->name,
            'payload' => $this->payload,
            'userId' => $this->userId
        ]);
    }
}
