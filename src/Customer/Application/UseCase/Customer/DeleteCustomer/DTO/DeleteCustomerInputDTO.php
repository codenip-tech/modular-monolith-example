<?php

declare(strict_types=1);

namespace Customer\Application\UseCase\Customer\DeleteCustomer\DTO;

use Customer\Domain\Exception\InvalidArgumentException;

class DeleteCustomerInputDTO
{
    private function __construct(
        public readonly string $id
    ) {
    }

    public static function create(?string $id): self
    {
        if (\is_null($id)) {
            throw InvalidArgumentException::createFromMessage('Customer ID can\'t be null');
        }

        return new static($id);
    }
}
