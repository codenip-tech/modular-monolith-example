<?php

namespace Employee\Service;

use Employee\Entity\Employee;
use Employee\Exception\EmployeeAlreadyExistsException;
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
        /*
         * CASE_0: Case for repository method with exception
         */
//        try {
//            $this->employeeRepository->findOneByEmailOrFail($email);
//
//            throw EmployeeAlreadyExistsException::createFromEmail($email);
//        } catch (ResourceNotFoundException) {
//            $employee = new Employee(Uuid::v4()->toRfc4122(), $name, $email);
//            $password = $this->passwordHasher->hashPasswordForUser($employee, $password);
//            $employee->setPassword($password);
//
//            $this->employeeRepository->save($employee);
//
//            return [
//                'id' => $employee->getId(),
//                'name' => $employee->getName(),
//                'email' => $employee->getEmail(),
//            ];
//        }

        /*
         * CASE_1: Case for repository method without exception
         */
        if (null !== $this->employeeRepository->findOneByEmail($email)) {
            throw EmployeeAlreadyExistsException::createFromEmail($email);
        }

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
