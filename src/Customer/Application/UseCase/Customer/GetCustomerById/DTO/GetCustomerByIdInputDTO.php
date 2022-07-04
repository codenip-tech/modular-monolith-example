<?php

declare(strict_types=1);

namespace Customer\Application\UseCase\Customer\GetCustomerById\DTO;

use Customer\Domain\Validation\Traits\AssertNotNullTrait;

class GetCustomerByIdInputDTO
{
    use AssertNotNullTrait;

    private const ARGS = ['id'];

    private function __construct(
        public readonly ?string $id
    ) {
        $this->assertNotNull(self::ARGS, [$this->id]);
    }

    public static function create(?string $id): self
    {
        return new static($id);
    }
}
