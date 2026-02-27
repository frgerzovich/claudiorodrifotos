<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case PHOTOGRAPHER = 'photographer';
}