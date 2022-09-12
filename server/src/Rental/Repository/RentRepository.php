<?php

declare(strict_types=1);

namespace Rental\Repository;

use rental\Entity\Rental;

interface RentRepository
{
    public function save(Rental $rental): void;
}
