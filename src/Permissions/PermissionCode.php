<?php declare(strict_types=1);

namespace Phpfs\Permissions;

enum PermissionCode: int
{
    case NONE = 0;
    case READ = 4;
    case WRITE = 2;
    case EXECUTE = 1;
}