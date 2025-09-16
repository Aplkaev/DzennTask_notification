<?php

namespace App\UseCase\NotificationMessage;

use App\Enum\NotificationMessage\TypeEnum;
use App\Repository\NotificationMessageRepository;

class ReadNotificationMessageUseCase
{
    public function __construct(
        private readonly NotificationMessageRepository $notificationMessageRepository
    ){}

    /**
     * @param string $userId
     * @param array<string> $notifications
     * @return void
     */
    public function execute(string $userId, array $notifications = []): void
    {
        $query = $this->notificationMessageRepository->createQueryBuilder('nm')
            ->update()
            ->join('nm.userChannel', 'uc')
            ->set('nm.isRead', ':isRead')
            ->where('uc.userId = :userId')
            ->setParameter('userId', $userId)
            ->setParameter('isRead', true)
            ->andWhere('nm.type = :type')
            ->setParameter('type', TypeEnum::SYSTEM);

        if($notifications !== []){
            $query->andWhere('nm.notificationId IN (:notificationIds)')
                ->setParameter('notificationIds', $notifications);
        }

        $query->getQuery()->execute();
    }
}
