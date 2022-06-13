<?php

declare(strict_types=1);

namespace Customer\Application\UseCase\Customer\CreateCustomer\DTO;

use Customer\Domain\Exception\InvalidArgumentException;

class CreateCustomerInputDTO
{
    private const         VALUES = [
        'name',
        'address',
        'age',
        'employeeId',
    ];
    private const MINIMUM_AGE = 18;

    private function __construct(
        public readonly string $name,
        public readonly string $address,
        public readonly int $age,
        public readonly string $employeeId
    ) {
    }

    public static function create(?string $name, ?string $address, ?int $age, ?string $employeeId): self
    {
        static::validateFields(\func_get_args());
        static::validateNameLength($name);
        static::checkAge($age);

        return new static($name, $address, $age, $employeeId);
    }

    private static function validateFields(array $fields): void
    {
        $values = \array_combine(self::VALUES, $fields);

        $emptyValues = [];
        foreach ($values as $key => $value) {
            if (\is_null($value)) {
                $emptyValues[] = $key;
            }
        }

        if (!empty($emptyValues)) {
            throw InvalidArgumentException::createFromArray($emptyValues);
        }
    }

    private static function validateNameLength(string $name): void
    {
        if (\strlen($name) < 2 || \strlen($name) > 10) {
            throw InvalidArgumentException::createFromArgument('name');
        }
    }

    private static function checkAge(int $age): void
    {
        if (self::MINIMUM_AGE > $age) {
            throw InvalidArgumentException::createFromMessage(\sprintf('Age has to be at least %d', self::MINIMUM_AGE));
        }
    }
}
