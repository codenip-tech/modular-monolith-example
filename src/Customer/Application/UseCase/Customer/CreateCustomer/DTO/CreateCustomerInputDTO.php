<?php

declare(strict_types=1);

namespace Customer\Application\UseCase\Customer\CreateCustomer\DTO;

use Customer\Domain\Exception\InvalidArgumentException;

class CreateCustomerInputDTO
{
    private function __construct(
        public readonly string $name,
        public readonly string $address,
        public readonly int $age,
        public readonly string $employeeId
    ) {
    }

    public static function create(?string $name, ?string $address, ?int $age, ?string $employeeId): self
    {
        if (\is_null($name) || \is_null($address) || \is_null($age) || \is_null($employeeId)) {
            throw InvalidArgumentException::createFromArray(['name', 'address', 'age', 'employeeId']);
        }

        return new static($name, $address, $age, $employeeId);
    }
}
