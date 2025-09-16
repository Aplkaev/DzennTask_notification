<?php

namespace App\Enum\NotificationMessage;

enum TypeEnum: string
{
    case SYSTEM = 'system';
    case EMAIL = 'email';
    case TELEGRAM = 'telegram';
}
