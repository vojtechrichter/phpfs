<?php declare(strict_types=1);

namespace Phpfs;

use Phpfs\Exceptions\PhpfsException;

final class Handle
{
    /**
     * @throws PhpfsException
     */
    public static function rename(string $file_or_dir_name, string $new_name): void
    {
        if (!rename($file_or_dir_name, $new_name)) {
            throw new PhpfsException("Failed to rename \'$file_or_dir_name\' to \'$new_name\'");
        }
    }

    /**
     * @throws PhpfsException
     */
    public static function copyFile(string $source, string $destination): void
    {
        if (!copy($source, $destination)) {
            throw new PhpfsException("Failed to copy \'$source\' to \'$destination\'");
        }
    }

    /**
     * @throws PhpfsException
     */
    public static function moveFile(string $source, string $destination): void
    {
        self::copyFile($source, $destination);
    }

    public static function fileOrDirExists(string $name): bool
    {
        return file_exists($name);
    }

    public static function getFreeDiskSpace(string $directory): float|false
    {
        return disk_free_space($directory);
    }

    /**
     * Permissions param should be supplied like this: Permission::calculatePermissions([PermissionCode::READ, PermissionCode::EXECUTE], [PermissionCode::NONE], [PermissionCode::WRITE])
     *
     * @throws PhpfsException
     */
    public static function changeMode(string $name, int $permissions): void
    {
        if (!chmod($name, $permissions)) {
            throw new PhpfsException("Failed to change mode on \'$name\' to $permissions");
        }
    }

    /**
     * @throws PhpfsException
     */
    public static function changeOwner(string $name, string|int $user): void
    {
        if (!chown($name, $user)) {
            throw new PhpfsException("Failed to change owner on \'$name\' to \'$user\'");
        }
    }

    /**
     * @throws PhpfsException
     */
    public static function remove(string $name): void
    {
        if (is_file($name)) {
            if (!unlink($name)) {
                throw new PhpfsException("Failed to remove file \'$name\'");
            }
        } else if (is_dir($name)) {
            if (!rmdir($name)) {
                throw new PhpfsException("Failed to remove directory \'$name\'");
            }
        } else {
            throw new PhpfsException("Specified path is not a file nor a directory");
        }
    }

    public static function getFileSize(string $filename): int|false
    {
        if (file_exists($filename)) {
            $size = filesize($filename);
            if ($size !== false) {
                return $size;
            } else {
                return false;
            }
        } else {
            throw new PhpfsException("File does not exist");
        }
    }

    public static function isDirectory(string $path): bool
    {
        return is_dir($path);
    }

    public static function isFile(string $path): bool
    {
        return is_file($path);
    }

    public static function isExecutable(string $path): bool
    {
        return is_executable($path);
    }

    /**
     * Possible return value are: fifo, char, dir, block, link, file, socket, unknown.
     *
     * @throws PhpfsException
     */
    public static function getFileType(string $path): string
    {
        $filetype = filetype($path);
        if ($filetype !== false) {
            return $filetype;
        } else {
            throw new PhpfsException("Failed to get file type of \'$path\'");
        }
    }

    /**
     * @throws PhpfsException
     */
    public static function makeDirectory(string $path, int $permissions, bool $recursive): void
    {
        if (!mkdir($path, $permissions, $recursive)) {
            throw new PhpfsException("Failed to create directory \'$path\'");
        }
    }

    /**
     * @throws PhpfsException
     */
    public static function createFile(string $name): void
    {
        $file = fopen($name, 'w');
        if ($file !== false) {
            fclose($file);
        } else {
            throw new PhpfsException("Failed to create file \'$name\'");
        }
    }
}