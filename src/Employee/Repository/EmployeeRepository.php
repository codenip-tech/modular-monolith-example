<?php

declare(strict_types=1);

namespace Employee\Repository;

use Employee\Entity\Employee;

interface EmployeeRepository
{
    public function save(Employee $employee): void;
}
