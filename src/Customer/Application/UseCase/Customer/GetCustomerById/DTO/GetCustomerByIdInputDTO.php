<?php

declare(strict_types=1);

namespace Customer\Application\UseCase\Customer\GetCustomerById\DTO;

use Customer\Domain\Exception\InvalidArgumentException;

class GetCustomerByIdInputDTO
{
    private function __construct(
        public readonly string $id
    ) {
    }

    public static function create(?string $id): self
    {
        if (\is_null($id)) {
            throw InvalidArgumentException::createFromArgument('id');
        }

        return new static($id);
    }
}
