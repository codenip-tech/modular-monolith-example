<?php

declare(strict_types=1);

namespace ModuleB\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use ModuleB\Entity\ModuleB;

class ModuleBRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, ModuleB::class);
    }
}