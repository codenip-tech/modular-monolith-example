<?php

declare(strict_types=1);

namespace Rent\Entity;

class Rent
{
    public function __construct(
        private readonly string $id,
        private readonly string $employeeId,
        private readonly string $customerId,
        private readonly Car $car,
        private readonly \DateTime $startDate,
        private readonly \DateTime $endDate,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmployeeId(): string
    {
        return $this->employeeId;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getCar(): Car
    {
        return $this->car;
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }
}
