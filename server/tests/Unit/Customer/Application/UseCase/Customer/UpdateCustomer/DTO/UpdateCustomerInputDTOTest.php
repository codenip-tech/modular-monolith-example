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
        'keys' => [],
    ];

    public function testCreateDTO(): void
    {
        $dto = UpdateCustomerInputDTO::create(
            self::DATA['id'],
            self::DATA['name'],
            self::DATA['address'],
            self::DATA['age'],
            self::DATA['keys']
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
            self::DATA['keys']
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
            self::DATA['keys']
        );
    }
}
