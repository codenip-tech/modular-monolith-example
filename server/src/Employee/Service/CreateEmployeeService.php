<?php

namespace Employee\Service;

use Employee\Entity\Employee;
use Employee\Repository\EmployeeRepository;
use Employee\Service\Security\PasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class CreateEmployeeService
{
    public function __construct(
        private readonly EmployeeRepository $employeeRepository,
        private readonly PasswordHasherInterface $passwordHasher
    ) {
    }

    public function create(string $name, string $email, string $password): array
    {
        $employee = new Employee(Uuid::v4()->toRfc4122(), $name, $email);
        $password = $this->passwordHasher->hashPasswordForUser($employee, $password);
        $employee->setPassword($password);

        $this->employeeRepository->save($employee);

        return [
            'id' => $employee->getId(),
            'name' => $employee->getName(),
            'email' => $employee->getEmail(),
        ];
    }
}
