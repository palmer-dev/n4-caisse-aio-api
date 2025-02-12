<?php

namespace App\Enums;

enum RolesEnum: string
{
    //
    case ADMIN    = 'administrator';
    case MANAGER  = 'manager';
    case EMPLOYEE = 'employee';
    case CLIENT   = 'client';
}
