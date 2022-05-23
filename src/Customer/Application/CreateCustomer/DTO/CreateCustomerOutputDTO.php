<?php

declare(strict_types=1);

namespace Customer\Application\CreateCustomer\DTO;

class CreateCustomerOutputDTO
{
    public function __construct(public readonly string $id)
    {
    }
}
