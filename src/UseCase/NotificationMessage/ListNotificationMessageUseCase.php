<?php

namespace App\UseCase\NotificationMessage;

use App\Entity\NotificationMessage;
use App\Enum\NotificationMessage\TypeEnum;
use App\Repository\NotificationMessageRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListNotificationMessageUseCase
{

    public function __construct(private NotificationMessageRepository $notificationMessageRepository)
    {

    }

    /**
     * @return NotificationMessage[]
     */
    public function execute(string $userId, ?bool $isRead = null): array
    {
        $list = [];
        $notificationMessages = $this->notificationMessageRepository->createQueryBuilder('nm')
            ->join('nm.user', 'u')
            ->where('u.id = :userId')
            ->setParameter('userId', $userId)
            ->andWhere('nm.type = :type')
            ->setParameter('type', TypeEnum::SYSTEM);

        if($isRead !== null) {
            $notificationMessages->andWhere('nm.isRead = :isRead')
                ->setParameter('isRead', $isRead);
        }

        $list = $notificationMessages->getQuery()->getResult();

        // добавить пагинацию
        return $list;
    }
}
