<?php

namespace App\UseCase\NotificationMessage;

use App\Entity\NotificationMessage;
use App\Enum\NotificationMessage\StatusEnum;
use App\Repository\NotificationMessageRepository;

class UpdateStatusUseCase
{
    public function __construct(
        private NotificationMessageRepository $notificationMessageRepository
    )
    {

    }

    public function execute(NotificationMessage $notificationMessage, StatusEnum $status = StatusEnum::SUCCESS): void
    {
        $notificationMessage->setStatus($status);
        $this->notificationMessageRepository->save($notificationMessage);
    }

}
