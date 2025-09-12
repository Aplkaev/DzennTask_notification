<?php

namespace App\Entity;

use App\Enum\RoleEnum;
use App\Enum\UserChannel\TypeEnum;
use Doctrine\ORM\Mapping as ORM;

class UserChannel extends BaseEntity
{
    #[ORM\Column(nullable: false)]
    private string $userId;

    #[ORM\Column(enumType: TypeEnum::class)]
    private TypeEnum $type;

    #[ORM\Column(nullable: true)]
    private string $address;
    #[ORM\Column(options: ['default' => true])]
    private bool $isActive;

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    public function getType(): TypeEnum
    {
        return $this->type;
    }

    public function setType(TypeEnum $type): void
    {
        $this->type = $type;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }


}
