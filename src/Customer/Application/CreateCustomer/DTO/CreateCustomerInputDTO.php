<?php

declare(strict_types=1);

namespace Customer\Application\CreateCustomer\DTO;

class CreateCustomerInputDTO
{
    private function __construct(
        public readonly string $name,
        public readonly string $address,
        public readonly int $age,
        public readonly string $employeeId
    ) {
    }

    public static function create(string $name, string $address, int $age, string $employeeId): self
    {
        return new self($name, $address, $age, $employeeId);
    }
}
