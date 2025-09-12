<?php

namespace App\Enum\NotificationMessage;

enum StatusEnum: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
    case PENDING = 'pending';
}
