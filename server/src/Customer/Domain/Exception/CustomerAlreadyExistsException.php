<?php

declare(strict_types=1);

namespace Customer\Domain\Exception;

final class CustomerAlreadyExistsException extends \DomainException
{
    public static function fromEmail(string $email): self
    {
        return new self(\sprintf('Customer with email [%s] already exists', $email));
    }
}
