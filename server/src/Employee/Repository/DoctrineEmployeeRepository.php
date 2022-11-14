<?php

declare(strict_types=1);

namespace Employee\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Employee\Entity\Employee;
use Employee\Exception\DatabaseException;
use Employee\Exception\ResourceNotFoundException;

class DoctrineEmployeeRepository implements EmployeeRepository
{
    private readonly ServiceEntityRepository $repository;
    private readonly ObjectManager $manager;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->repository = new ServiceEntityRepository($managerRegistry, Employee::class);
        $this->manager = $managerRegistry->getManager('employee_em');
    }

    public function save(Employee $employee): void
    {
        try {
            $this->manager->persist($employee);
            $this->manager->flush();
        } catch (\Exception $e) {
            throw DatabaseException::createFromMessage($e->getMessage());
        }
    }

    public function remove(Employee $employee): void
    {
        try {
            $this->manager->remove($employee);
            $this->manager->flush();
        } catch (\Exception $e) {
            throw DatabaseException::createFromMessage($e->getMessage());
        }
    }

    public function findOneByEmail(string $email): ?Employee
    {
        return $this->repository->findOneBy(['email' => $email]);
    }

    public function findOneByEmailOrFail(string $email): Employee
    {
        if (null === $employee = $this->repository->findOneBy(['email' => $email])) {
            throw ResourceNotFoundException::createFromResourceAndProperty(Employee::class, $email);
        }

        return $employee;
    }

    public function findOneByIdOrFail(string $id): Employee
    {
        if (null === $employee = $this->repository->find($id)) {
            throw ResourceNotFoundException::createFromResourceAndId(Employee::class, $id);
        }

        return $employee;
    }
}
