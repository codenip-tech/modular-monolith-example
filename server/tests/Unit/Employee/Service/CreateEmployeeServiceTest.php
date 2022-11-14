<?php

declare(strict_types=1);

namespace App\Tests\Unit\Employee\Service;

use Customer\Domain\ValueObject\Uuid;
use Employee\Entity\Employee;
use Employee\Exception\EmployeeAlreadyExistsException;
use Employee\Exception\ResourceNotFoundException;
use Employee\Repository\EmployeeRepository;
use Employee\Service\CreateEmployeeService;
use Employee\Service\Security\PasswordHasherInterface;
use PHPUnit\Framework\TestCase;

final class CreateEmployeeServiceTest extends TestCase
{
    private readonly EmployeeRepository $employeeRepository;
    private readonly PasswordHasherInterface $passwordHasher;
    private readonly CreateEmployeeService $service;

    public function setUp(): void
    {
        $this->employeeRepository = $this->createMock(EmployeeRepository::class);
        $this->passwordHasher = $this->createMock(PasswordHasherInterface::class);
        $this->service = new CreateEmployeeService($this->employeeRepository, $this->passwordHasher);
    }

    public function testCreateEmployee(): void
    {
        $name = 'Peter';
        $email = 'peter@api.com';
        $password = 'Password1!';

        $this->passwordHasher
            ->expects($this->once())
            ->method('hashPasswordForUser')
            ->with(
                $this->callback(function (Employee $employee) use ($name, $email): bool {
                    return $employee->getName() === $name
                        && $employee->getEmail() === $email;
                }),
                $this->callback(function (string $plainPassword) use ($password): bool {
                    return $plainPassword === $password;
                })
            )
            ->willReturn('super-encrypted-password');

        $this->employeeRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->callback(fn(Employee $employee) => $employee->getName() === $name && $employee->getEmail() === $email));

        $output = $this->service->create($name, $email, $password);

        self::assertArrayHasKey('id', $output);
        self::assertArrayHasKey('name', $output);
        self::assertArrayHasKey('email', $output);
        self::assertEquals($name, $output['name']);
        self::assertEquals($email, $output['email']);
    }

    /**
     * CASE_0: Case for repository method with exception
     */
//    public function testCreateEmployeeWithExistingEmail(): void
//    {
//        $name = 'Peter';
//        $email = 'peter@api.com';
//        $password = 'Password1!';
//
//        $this->employeeRepository
//            ->expects($this->once())
//            ->method('findOneByEmailOrFail')
//            ->with($email)
//            ->willThrowException(ResourceNotFoundException::createFromResourceAndProperty(Employee::class, $email));
//
//        $this->passwordHasher
//            ->expects($this->once())
//            ->method('hashPasswordForUser')
//            ->with(
//                $this->callback(function (Employee $employee) use ($name, $email): bool {
//                    return $employee->getName() === $name
//                        && $employee->getEmail() === $email;
//                }),
//                $this->callback(function (string $plainPassword) use ($password): bool {
//                    return $plainPassword === $password;
//                })
//            )
//            ->willReturn('super-encrypted-password');
//
//        $this->employeeRepository
//            ->expects($this->once())
//            ->method('save')
//            ->with($this->callback(fn(Employee $employee) => $employee->getName() === $name && $employee->getEmail() === $email));
//
//        $this->service->create($name, $email, $password);
//    }

    /**
     * CASE_1: Case for repository method without exception
     */
    public function testCreateEmployeeWithExistingEmail(): void
    {
        $name = 'Peter';
        $email = 'peter@api.com';
        $password = 'Password1!';

        $employee = new Employee(Uuid::random()->value(), $name, $email);

        $this->employeeRepository
            ->expects($this->once())
            ->method('findOneByEmail')
            ->with($email)
            ->willReturn($employee);

        self::expectException(EmployeeAlreadyExistsException::class);

        $this->service->create($name, $email, $password);
    }
}
