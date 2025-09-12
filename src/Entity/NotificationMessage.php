<?php

namespace App\Entity;

use App\Enum\NotificationMessage\StatusEnum;
use App\Enum\NotificationMessage\TypeEnum;
use Doctrine\ORM\Mapping as ORM;

class NotificationMessage extends BaseEntity
{
    #[ORM\Column(enumType: TypeEnum::class)]
    private TypeEnum $type;

    #[ORM\Column]
    private string $name;

    #[ORM\ManyToOne(inversedBy: 'notificationMessage')]
    #[ORM\JoinColumn(nullable: false)]
    private UserChannel $userChannel;

    #[ORM\Column(enumType: StatusEnum::class)]
    private StatusEnum $status;

    #[ORM\Column(type: 'json')]
    private array $payload;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isRead = false;

    public function getType(): TypeEnum
    {
        return $this->type;
    }

    public function setType(TypeEnum $type): void
    {
        $this->type = $type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getUserChannel(): UserChannel
    {
        return $this->userChannel;
    }

    public function setUserChannel(UserChannel $userChannel): void
    {
        $this->userChannel = $userChannel;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function setStatus(StatusEnum $status): void
    {
        $this->status = $status;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }

    public function isRead(): bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead): void
    {
        $this->isRead = $isRead;
    }
}
