<?php

namespace App\Dto\Notification;

use App\Dto\BaseFromModalDto;
use App\Dto\BaseJsonSerializeDto;
use App\Entity\BaseEntity;
use App\Entity\NotificationMessage;
use App\Enum\NotificationMessage\StatusEnum;

final class NotificationListDto implements BaseFromModalDto, BaseJsonSerializeDto
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly StatusEnum $status,
        private readonly array $payload,
        private readonly bool $isRead,
    )
    {

    }

    /**
     * @param NotificationMessage $model
     */
    public static function fromModel(BaseEntity|NotificationMessage $model): static
    {
        return new static(
            id: $model->getStringId(),
            name: $model->getName(),
            status:$model->getStatus(),
            payload: $model->getPayload(),
            isRead: $model->isRead()
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'status'=>$this->status,
            'payload'=>$this->payload,
            'isRead'=>$this->isRead,
        ];
    }
}
