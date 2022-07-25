<?php

declare(strict_types=1);

namespace Customer\Domain\Exception;

class ResourceNotFoundException extends \DomainException
{
    public static function createFromClassAndId(string $class, string $id): self
    {
        return new static(\sprintf('Resource of type [%s] with ID [%s] not found', $class, $id));
    }
}
