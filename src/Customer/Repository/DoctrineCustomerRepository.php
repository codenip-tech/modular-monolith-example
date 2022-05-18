<?php

declare(strict_types=1);

namespace Customer\Repository;

use App\Customer\Repository\CustomerRepository;
use Customer\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class DoctrineCustomerRepository implements CustomerRepository
{
    private readonly ServiceEntityRepository $repository;
    private readonly ObjectManager $manager;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->repository = new ServiceEntityRepository($managerRegistry, Customer::class);
        $this->manager = $managerRegistry->getManager();
    }

    public function save(Customer $customer): void
    {
        $this->manager->persist($customer);
        $this->manager->flush();
    }
}
