<?php

declare(strict_types=1);

namespace App\Tests\Unit\Employee\Service;

use Customer\Domain\ValueObject\Uuid;
use Employee\Entity\Employee;
use Employee\Exception\ResourceNotFoundException;
use Employee\Repository\EmployeeRepository;
use Employee\Service\RemoveEmployeeService;
use PHPUnit\Framework\TestCase;

final class RemoveEmployeeServiceTest extends TestCase
{
    private readonly EmployeeRepository $employeeRepository;
    private readonly RemoveEmployeeService $service;

    public function setUp(): void
    {
        $this->employeeRepository = $this->createMock(EmployeeRepository::class);
        $this->service = new RemoveEmployeeService($this->employeeRepository);
    }

    public function testRemoveEmployee(): void
    {
        $email = 'peter@api.com';

        $employee = new Employee(Uuid::random()->value(), 'Peter', $email);

        $this->employeeRepository
            ->expects($this->once())
            ->method('findOneByEmail')
            ->with($email)
            ->willReturn($employee);

        $this->employeeRepository
            ->expects($this->once())
            ->method('remove')
            ->with($this->callback(fn(Employee $employee) => $employee->getEmail() === $email));

        $this->service->remove($email);
    }

    public function testRemoveNonExistingEmployee(): void
    {
        $email = 'peter@api.com';

        $this->employeeRepository
            ->expects($this->once())
            ->method('findOneByEmail')
            ->with($email)
            ->willReturn(null);

        self::expectException(ResourceNotFoundException::class);

        $this->service->remove($email);
    }
}
