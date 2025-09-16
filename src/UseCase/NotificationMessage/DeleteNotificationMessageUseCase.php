<?php

namespace App\UseCase\NotificationMessage;

use App\Entity\NotificationMessage;
use App\Repository\NotificationMessageRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteNotificationMessageUseCase
{

    public function __construct(
        private readonly NotificationMessageRepository $notificationMessageRepository,
    )
    {

    }

    public function execute(NotificationMessage $message): void
    {
        $this->notificationMessageRepository->delete($message);
    }

}
