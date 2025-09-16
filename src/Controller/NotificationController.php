<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\BaseDto;
use App\Dto\Notification\NotificationListDto;
use App\Entity\NotificationMessage;
use App\Repository\NotificationMessageRepository;
use App\Shared\Parser\ParseDataTrait;
use App\Shared\Response\ApiResponse;
use App\UseCase\Crud\AbstractCrudUseCase;
use App\UseCase\NotificationMessage\DeleteNotificationMessageUseCase;
use App\UseCase\NotificationMessage\ListNotificationMessageUseCase;
use App\UseCase\NotificationMessage\ReadNotificationMessageUseCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
class NotificationController extends AbstractController
{
    use ParseDataTrait;

    public function __construct(
        protected readonly ListNotificationMessageUseCase $listNotificationMessage,
        protected readonly ReadNotificationMessageUseCase $readNotificationMessageUseCase,
        protected readonly DeleteNotificationMessageUseCase $deleteNotificationMessageUseCase
    ) {
    }

    #[Route('', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $userId = '';
        $isRead = false;
        $items = $this->listNotificationMessage->execute($userId, $isRead);
        return ApiResponse::responseList(
            self::parseResponseDtoList(NotificationListDto::class, $items),
        );
    }

    #[Route('/list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $userId = '';
        $isRead = null;
        $items = $this->listNotificationMessage->execute($userId, $isRead);
        return ApiResponse::responseList(
            self::parseResponseDtoList(NotificationListDto::class, $items),
        );
    }

    #[Route('/read/all', methods: ['POST'])]
    public function readAll(): JsonResponse
    {
        $userId = '';
        $this->readNotificationMessageUseCase->execute($userId);
        return ApiResponse::success();
    }

    #[Route('/read/{id}', methods: ['POST'])]
    public function read(NotificationMessage $message): JsonResponse
    {
        $userId = '';
        $this->readNotificationMessageUseCase->execute($userId, [$message->getStringId()]);
        return ApiResponse::success();
    }

    #[Route('/delete/{id}', methods: ['DELETE'])]
    public function delete(NotificationMessage $message): JsonResponse
    {
        $this->deleteNotificationMessageUseCase->execute($message);
        
        return ApiResponse::success(status: Response::HTTP_NO_CONTENT);
    }
}
