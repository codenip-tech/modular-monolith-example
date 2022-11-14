<?php

declare(strict_types=1);

namespace Employee\Repository;

use Employee\Entity\Employee;

interface EmployeeRepository
{
    public function save(Employee $employee): void;

    public function remove(Employee $employee): void;

    public function findOneByEmail(string $email): ?Employee;

    public function findOneByEmailOrFail(string $email): Employee;

    public function findOneByIdOrFail(string $id): Employee;
}
