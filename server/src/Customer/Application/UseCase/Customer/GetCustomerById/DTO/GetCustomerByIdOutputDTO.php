<?php

declare(strict_types=1);

namespace Customer\Application\UseCase\Customer\GetCustomerById\DTO;

use Customer\Domain\Model\Customer;

class GetCustomerByIdOutputDTO
{
    private function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $address,
        public readonly int $age,
        public readonly string $employeeId,
    ) {
    }

    public static function create(Customer $customer): self
    {
        return new self(
            $customer->id(),
            $customer->name(),
            $customer->email(),
            $customer->address(),
            $customer->age(),
            $customer->employeeId(),
        );
    }
}
