<?php

declare(strict_types=1);

namespace Customer\Infrastructure\Database\ORM\Doctrine\Entity;

use Customer\Domain\Model\Customer;

class DoctrineCustomer
{
    public function __construct(
        private readonly string $id,
        private string $name,
        private string $address,
        private int $age,
        private readonly string $employeeId,
    ) {
    }

    public static function createFromDomainCustomer(Customer $customer): self
    {
        return new self($customer->id(), $customer->name(), $customer->address(), $customer->age(), $customer->employeeId());
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function address(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function age(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function employeeId(): string
    {
        return $this->employeeId;
    }
}
