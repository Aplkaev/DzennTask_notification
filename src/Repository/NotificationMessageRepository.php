<?php

namespace App\Repository;

use App\Entity\NotificationMessage;

class NotificationMessageRepository extends BaseEntityRepository
{

    public function entityClass(): string
    {
        return NotificationMessage::class;
    }
}
