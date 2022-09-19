<?php

namespace Employee\Exception;

class DatabaseException extends \DomainException
{
    public static function createFromMessage(string $message): self
    {
        return new self(\sprintf('Database error. Message: %s', $message));
    }
}
