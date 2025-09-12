<?php

namespace App\UseCase\NotificationMessage;

use App\Entity\NotificationMessage;
use App\Enum\NotificationMessage\StatusEnum;
use App\Repository\NotificationMessageRepository;
use App\UseCase\UserChannel\GetListUserChannelUseCase;

class SaveNotificationMessageUseCase
{

    public function __construct(
        private NotificationMessageRepository $notificationMessageRepository,
        private GetListUserChannelUseCase $getListUserChannelUseCase,

    )
    {

    }


    /**
     * @param \App\Message\NotificationMessage $message
     * @return NotificationMessage[]
     */
    public function execute(\App\Message\NotificationMessage $message): array
    {
        $userChannelList = $this->getListUserChannelUseCase->execute($message->userId);
        $messageList = [];
        foreach ($userChannelList as $userChannel) {
            $messageEntity = new NotificationMessage();
            $messageEntity->setName($message->name);
            $messageEntity->setPayload($message->payload);
            $messageEntity->setUserChannel($userChannel);
            $messageEntity->setStatus(StatusEnum::PENDING);

            $messageList[] = $this->notificationMessageRepository->save($messageEntity);
        }

        return $messageList;
    }
}
