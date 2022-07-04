<?php

declare(strict_types=1);

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\GetCustomerById\DTO;

use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdInputDTO;
use Customer\Domain\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class GetCustomerByIdInputDTOTest extends TestCase
{
    private const CUSTOMER_ID = '9b5c0b1f-09bf-4fed-acc9-fcaafc933a19';

    public function testCreateGetCustomerByIdInputDTO(): void
    {
        $dto = GetCustomerByIdInputDTO::create(self::CUSTOMER_ID);

        self::assertInstanceOf(GetCustomerByIdInputDTO::class, $dto);
        self::assertEquals(self::CUSTOMER_ID, $dto->id);
    }

    public function testCreateGetCustomerByIdInputDTOWithNullValue(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Invalid arguments [id]');

        GetCustomerByIdInputDTO::create(null);
    }
}