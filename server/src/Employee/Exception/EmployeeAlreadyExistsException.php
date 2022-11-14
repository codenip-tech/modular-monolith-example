<?php

declare(strict_types=1);

namespace Employee\Exception;

final class EmployeeAlreadyExistsException extends \DomainException
{
    public static function createFromEmail(string $email): self
    {
        return new EmployeeAlreadyExistsException(\sprintf('Employee with email <%s> already exists', $email));
    }
}
