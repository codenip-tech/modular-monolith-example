<?php

declare(strict_types=1);

namespace Customer\Application\UseCase\Customer\CreateCustomer\DTO;

use Customer\Domain\Exception\InvalidArgumentException;
use Customer\Domain\Validation\Traits\AssertNotNullTrait;

class CreateCustomerInputDTO
{
    use AssertNotNullTrait;

    private const ARGS = [
        'name',
        'address',
        'age',
        'employeeId',
    ];
    private const MINIMUM_AGE = 18;

    private function __construct(
        public readonly ?string $name,
        public readonly ?string $address,
        public readonly ?int $age,
        public readonly ?string $employeeId
    ) {
        $this->assertNotNull(self::ARGS, [$this->name, $this->address, $this->age, $this->employeeId]);
        $this->assertNameLength($this->name);
        $this->assertMinimumAge($this->age);
    }

    public static function create(?string $name, ?string $address, ?int $age, ?string $employeeId): self
    {
        return new static($name, $address, $age, $employeeId);
    }

    private function assertNameLength(string $name): void
    {
        if (\strlen($name) < 2 || \strlen($name) > 10) {
            throw InvalidArgumentException::createFromArgument('name');
        }
    }

    private function assertMinimumAge(int $age): void
    {
        if (self::MINIMUM_AGE > $age) {
            throw InvalidArgumentException::createFromMessage(\sprintf('Age has to be at least %d', self::MINIMUM_AGE));
        }
    }
}
