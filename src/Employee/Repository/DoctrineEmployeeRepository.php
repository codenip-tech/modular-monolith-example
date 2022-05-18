<?php

declare(strict_types=1);

namespace Employee\Repository;

use App\Employee\Repository\EmployeeRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Employee\Entity\Employee;

class DoctrineEmployeeRepository implements EmployeeRepository
{
    private readonly ServiceEntityRepository $repository;
    private readonly ObjectManager $manager;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->repository = new ServiceEntityRepository($managerRegistry, Employee::class);
        $this->manager = $managerRegistry->getManager();
    }

    public function save(Employee $employee): void
    {
        $this->manager->persist($employee);
        $this->manager->flush();
    }
}
