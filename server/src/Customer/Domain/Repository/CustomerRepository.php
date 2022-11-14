<?php

declare(strict_types=1);

namespace Customer\Domain\Repository;

use Customer\Adapter\Framework\Http\API\Filter\CustomerFilter;
use Customer\Adapter\Framework\Http\API\Response\PaginatedResponse;
use Customer\Domain\Model\Customer;

interface CustomerRepository
{
    public function findOneByIdOrFail(string $id): Customer;

    public function search(CustomerFilter $filter): PaginatedResponse;

    public function save(Customer $customer): void;

    public function remove(Customer $customer): void;
}
