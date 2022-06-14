<?php

declare(strict_types=1);

namespace Customer\Domain\Repository;

use Customer\Domain\Model\Customer;

interface CustomerRepository
{
    public function findOneByIdOrFail(string $id): Customer;

    public function save(Customer $customer): void;
}
