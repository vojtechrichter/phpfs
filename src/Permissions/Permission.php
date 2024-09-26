<?php declare(strict_types=1);

namespace Phpfs\Permissions;

final class Permission
{
    /**
     * @param int[] $user
     * @param int[] $group
     * @param int[] $others
     * @return int
     */
    public static function calculatePermissions(array $user, array $group, array $others): int
    {
        return (int)('0' . (int)array_sum($user) . (int)array_sum($group) . (int)array_sum($others));
    }
}