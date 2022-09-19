<?php

namespace Employee\Service;

use Employee\Repository\EmployeeRepository;

class RemoveEmployeeService
{
    public function __construct(
        private readonly EmployeeRepository $employeeRepository
    ) {
    }

    public function remove(string $email): void
    {
        $employee = $this->employeeRepository->findOneByEmailOrFail($email);

        $this->employeeRepository->remove($employee);
    }
}
