<?php

namespace Employee\Service;

use Employee\Entity\Employee;
use Employee\Exception\ResourceNotFoundException;
use Employee\Repository\EmployeeRepository;

class RemoveEmployeeService
{
    public function __construct(
        private readonly EmployeeRepository $employeeRepository
    ) {
    }

    public function remove(string $email): void
    {
        if (null === $employee = $this->employeeRepository->findOneByEmail($email)) {
            throw ResourceNotFoundException::createFromResourceAndProperty(Employee::class, $email);
        }

        $this->employeeRepository->remove($employee);
    }
}
