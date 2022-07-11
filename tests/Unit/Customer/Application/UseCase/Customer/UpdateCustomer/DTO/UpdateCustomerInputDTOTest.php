<?php

declare(strict_types=1);

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\UpdateCustomer\DTO;

use Customer\Application\UseCase\Customer\UpdateCustomer\DTO\UpdateCustomerInputDTO;
use Customer\Domain\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UpdateCustomerInputDTOTest extends TestCase
{
    private const DATA = [
        'id' => '37fb348b-891a-4b1c-a4e4-a4a68a3c6bae',
        'name' => 'Brian',
        'address' => 'Test address 123',
        'age' => 20,
    ];

    public function testCreateDTO(): void
    {
        $dto = UpdateCustomerInputDTO::create(
            self::DATA['id'],
            self::DATA['name'],
            self::DATA['address'],
            self::DATA['age'],
        );

        self::assertInstanceOf(UpdateCustomerInputDTO::class, $dto);
    }

    public function testCreateWithNullId(): void
    {
        self::expectException(InvalidArgumentException::class);

        UpdateCustomerInputDTO::create(
            null,
            self::DATA['name'],
            self::DATA['address'],
            self::DATA['age'],
        );
    }

    public function testCreateWithNullAge(): void
    {
        self::expectException(InvalidArgumentException::class);

        UpdateCustomerInputDTO::create(
            self::DATA['id'],
            self::DATA['name'],
            self::DATA['address'],
            null,
        );
    }

    public function testCreateWithInvalidAge(): void
    {
        self::expectException(InvalidArgumentException::class);

        UpdateCustomerInputDTO::create(
            self::DATA['id'],
            self::DATA['name'],
            self::DATA['address'],
            10,
        );
    }
}
