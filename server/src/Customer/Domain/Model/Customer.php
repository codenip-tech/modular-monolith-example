<?php

declare(strict_types=1);

namespace Customer\Domain\Model;

class Customer
{
    public const NAME_MIN_LENGTH = 2;
    public const NAME_MAX_LENGTH = 10;
    public const MIN_AGE = 18;

    public function __construct(
        private readonly string $id,
        private ?string $name,
        private ?string $email,
        private ?string $address,
        private int $age,
        private readonly string $employeeId,
    ) {
    }

    public static function create(string $id, ?string $name, ?string $email, ?string $address, int $age, string $employeeId): self
    {
        return new static($id, $name, $email, $address, $age, $employeeId);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function email(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function address(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
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
