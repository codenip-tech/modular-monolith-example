<?php

declare(strict_types=1);

namespace App\Customer\Repository;

use Customer\Entity\Customer;

interface CustomerRepository
{
    public function save(Customer $customer): void;
}
