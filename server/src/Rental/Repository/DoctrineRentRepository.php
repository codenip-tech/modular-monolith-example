<?php

declare(strict_types=1);

namespace Rental\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ObjectManager;
use rental\Entity\Rental;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class DoctrineRentRepository implements RentRepository
{
    private readonly ServiceEntityRepository $repository;
    private readonly ObjectManager $manager;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->repository = new ServiceEntityRepository($managerRegistry, Rental::class);
        $this->manager = $managerRegistry->getManager();
    }

    public function save(Rental $rental): void
    {
        $this->manager->persist($rental);
        $this->manager->flush();
    }
}
