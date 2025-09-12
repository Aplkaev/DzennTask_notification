<?php

namespace App\UseCase\NotificationMessage;

use App\Enum\NotificationMessage\StatusEnum;
use Psr\Log\LoggerInterface;

class SendNotificationMessageUseCase
{

    public function __construct(
        private readonly UpdateStatusUseCase $updateStatusUseCase,
        private readonly LoggerInterface $logger
    )
    {

    }

    public function execute(array $messageList): void
    {
        foreach ($messageList as $message) {
            $status = StatusEnum::SUCCESS;
            try {
                // отправка в канал

            } catch (\Exception $e) {
                $status = StatusEnum::ERROR;
                $this->logger->error($e->getMessage());
            }

            // обновление статуса сообщения
            $this->updateStatusUseCase->execute($message, $status);
        }
    }
}
