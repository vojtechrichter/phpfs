<?php declare(strict_types=1);

namespace Phpfs\Exceptions;

final class PhpfsException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}