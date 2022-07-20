<?php

declare(strict_types=1);

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\UpdateCustomer;

use Customer\Application\UseCase\Customer\UpdateCustomer\DTO\UpdateCustomerInputDTO;
use Customer\Application\UseCase\Customer\UpdateCustomer\DTO\UpdateCustomerOutputDTO;
use Customer\Application\UseCase\Customer\UpdateCustomer\UpdateCustomer;
use Customer\Domain\Exception\ResourceNotFoundException;
use Customer\Domain\Model\Customer;
use Customer\Domain\Repository\CustomerRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UpdateCustomerTest extends TestCase
{
    private const DATA = [
        'id' => '37fb348b-891a-4b1c-a4e4-a4a68a3c6bae',
        'name' => 'Brian',
        'address' => 'Test address 123',
        'age' => 20,
    ];

    private const DATA_TO_UPDATE = [
        'id' => '37fb348b-891a-4b1c-a4e4-a4a68a3c6bae',
        'name' => 'Peter',
        'address' => 'Address 111',
        'age' => 40,
        'keys' => [
            'name',
            'address',
            'age',
        ],
    ];

    private const EMPLOYEE_ID = '37fb348b-891a-4b1c-a4e4-a4a68a3c6111';

    private CustomerRepository|MockObject $customerRepository;

    private UpdateCustomerInputDTO $inputDTO;

    private UpdateCustomer $useCase;

    public function setUp(): void
    {
        $this->customerRepository = $this->createMock(CustomerRepository::class);

        $this->inputDTO = UpdateCustomerInputDTO::create(
            self::DATA_TO_UPDATE['id'],
            self::DATA_TO_UPDATE['name'],
            self::DATA_TO_UPDATE['address'],
            self::DATA_TO_UPDATE['age'],
            self::DATA_TO_UPDATE['keys']
        );

        $this->useCase = new UpdateCustomer($this->customerRepository);
    }

    public function testUpdateCustomer(): void
    {
        $customer = Customer::create(
            self::DATA['id'],
            self::DATA['name'],
            self::DATA['address'],
            self::DATA['age'],
            self::EMPLOYEE_ID
        );

        $this->customerRepository
            ->expects($this->once())
            ->method('findOneByIdOrFail')
            ->with($this->inputDTO->id)
            ->willReturn($customer);

        $this->customerRepository
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(function (Customer $customer): bool {
                    return $customer->name() === $this->inputDTO->name
                        && $customer->address() === $this->inputDTO->address
                        && $customer->age() === $this->inputDTO->age;
                })
            );

        $responseDTO = $this->useCase->handle($this->inputDTO);

        self::assertInstanceOf(UpdateCustomerOutputDTO::class, $responseDTO);

        self::assertEquals($this->inputDTO->name, $responseDTO->customerData['name']);
        self::assertEquals($this->inputDTO->address, $responseDTO->customerData['address']);
        self::assertEquals($this->inputDTO->age, $responseDTO->customerData['age']);
    }
}
