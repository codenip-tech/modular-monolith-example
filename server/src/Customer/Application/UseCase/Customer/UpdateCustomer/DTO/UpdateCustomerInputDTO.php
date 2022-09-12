<?php

declare(strict_types=1);

namespace Customer\Application\UseCase\Customer\UpdateCustomer\DTO;

use Customer\Domain\Model\Customer;
use Customer\Domain\Validation\Traits\AssertLengthRangeTrait;
use Customer\Domain\Validation\Traits\AssertMinimumAgeTrait;
use Customer\Domain\Validation\Traits\AssertNotNullTrait;

class UpdateCustomerInputDTO
{
    use AssertLengthRangeTrait;
    use AssertMinimumAgeTrait;
    use AssertNotNullTrait;

    private const ARGS = ['id'];

    private function __construct(
        public readonly ?string $id,
        public readonly ?string $name,
        public readonly ?string $email,
        public readonly ?string $address,
        public readonly ?int $age,
        public readonly array $paramsToUpdate
    ) {
        $this->assertNotNull(self::ARGS, [$this->id]);

        if (!\is_null($this->name)) {
            $this->assertValueRangeLength($this->name, Customer::NAME_MIN_LENGTH, Customer::NAME_MAX_LENGTH);
        }

        if (!\is_null($this->age)) {
            $this->assertMinimumAge($this->age, Customer::MIN_AGE);
        }
    }

    public static function create(?string $id, ?string $name, ?string $email, ?string $address, ?int $age, array $paramsToUpdate): self
    {
        return new static($id, $name, $email, $address, $age, $paramsToUpdate);
    }
}
