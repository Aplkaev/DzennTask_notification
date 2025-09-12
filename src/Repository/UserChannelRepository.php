<?php

namespace App\Repository;


use App\Entity\UserChannel;

class UserChannelRepository extends BaseEntityRepository
{

    public function entityClass(): string
    {
        return UserChannel::class;
    }
}
