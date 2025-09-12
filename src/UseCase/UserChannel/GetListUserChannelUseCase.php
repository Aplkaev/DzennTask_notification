<?php

namespace App\UseCase\UserChannel;

use App\Entity\UserChannel;
use App\Repository\UserChannelRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetListUserChannelUseCase
{
    public function __construct(
        private UserChannelRepository $userChannelRepository,
    )
    {

    }

    /**
     * @param string $userId
     * @return UserChannel[]
     */
    public function execute(string $userId): array
    {
        $userChannel = $this->userChannelRepository->findBy(['$userId'=>$userId]);

        if(!$userChannel){
            throw new NotFoundHttpException('Not found user channel with user_id:'.$userId);
        }

        return $userChannel;
    }

}
