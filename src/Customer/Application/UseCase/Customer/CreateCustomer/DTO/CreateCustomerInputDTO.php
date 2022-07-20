<?php

declare(strict_types=1);

namespace Customer\Application\UseCase\Customer\CreateCustomer\DTO;

use Customer\Domain\Model\Customer;
use Customer\Domain\Validation\Traits\AssertLengthRangeTrait;
use Customer\Domain\Validation\Traits\AssertMinimumAgeTrait;
use Customer\Domain\Validation\Traits\AssertNotNullTrait;

class CreateCustomerInputDTO
{
    use AssertNotNullTrait;
    use AssertLengthRangeTrait;
    use AssertMinimumAgeTrait;

    private const ARGS = [
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
        $this->assertNotNull(self::ARGS, [$this->age, $this->employeeId]);

        if (!\is_null($this->name)) {
            $this->assertValueRangeLength($this->name, Customer::NAME_MIN_LENGTH, Customer::NAME_MAX_LENGTH);
        }

        $this->assertMinimumAge($this->age, Customer::MIN_AGE);
    }

    public static function create(?string $name, ?string $address, ?int $age, ?string $employeeId): self
    {
        return new static($name, $address, $age, $employeeId);
    }
}
