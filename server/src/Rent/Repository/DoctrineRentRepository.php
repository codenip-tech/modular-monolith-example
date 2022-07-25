<?php

declare(strict_types=1);

namespace Rent\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ObjectManager;
use Rent\Entity\Rent;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class DoctrineRentRepository implements RentRepository
{
    private readonly ServiceEntityRepository $repository;
    private readonly ObjectManager $manager;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->repository = new ServiceEntityRepository($managerRegistry, Rent::class);
        $this->manager = $managerRegistry->getManager();
    }

    public function save(Rent $rent): void
    {
        $this->manager->persist($rent);
        $this->manager->flush();
    }
}
