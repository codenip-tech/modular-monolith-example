<?php

namespace Employee\Exception;

class ResourceNotFoundException extends \DomainException
{
    public static function createFromResourceAndProperty(string $resource, string $property): self
    {
        return new self(\sprintf('Resource of type [%s] with property [%s] not found', $resource, $property));
    }
}
