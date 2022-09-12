<?php

declare(strict_types=1);

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\GetCustomerById;

use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdInputDTO;
use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdOutputDTO;
use Customer\Application\UseCase\Customer\GetCustomerById\GetCustomerById;
use Customer\Domain\Exception\ResourceNotFoundException;
use Customer\Domain\Model\Customer;
use Customer\Domain\Repository\CustomerRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetCustomerByIdTest extends TestCase
{
    private const CUSTOMER_DATA = [
        'id' => '9b5c0b1f-09bf-4fed-acc9-fcaafc933a19',
        'name' => 'Peter',
        'email' => 'peter@api.com',
        'address' => 'Fake street 123',
        'age' => 30,
        'employeeId' => '9b5c0b1f-09bf-4fed-acc9-fcaafc933000',
    ];

    private CustomerRepository|MockObject $customerRepository;

    private GetCustomerById $useCase;

    public function setUp(): void
    {
        $this->customerRepository = $this->createMock(CustomerRepository::class);

        $this->useCase = new GetCustomerById($this->customerRepository);
    }

    public function testGetCustomerById(): void
    {
        $inputDto = GetCustomerByIdInputDTO::create(self::CUSTOMER_DATA['id']);

        $customer = Customer::create(
            self::CUSTOMER_DATA['id'],
            self::CUSTOMER_DATA['name'],
            self::CUSTOMER_DATA['email'],
            self::CUSTOMER_DATA['address'],
            self::CUSTOMER_DATA['age'],
            self::CUSTOMER_DATA['employeeId'],
        );

        $this->customerRepository
            ->expects($this->once())
            ->method('findOneByIdOrFail')
            ->with($inputDto->id)
            ->willReturn($customer);

        $responseDTO = $this->useCase->handle($inputDto);

        self::assertInstanceOf(GetCustomerByIdOutputDTO::class, $responseDTO);

        self::assertEquals(self::CUSTOMER_DATA['id'], $responseDTO->id);
        self::assertEquals(self::CUSTOMER_DATA['name'], $responseDTO->name);
        self::assertEquals(self::CUSTOMER_DATA['email'], $responseDTO->email);
        self::assertEquals(self::CUSTOMER_DATA['address'], $responseDTO->address);
        self::assertEquals(self::CUSTOMER_DATA['age'], $responseDTO->age);
        self::assertEquals(self::CUSTOMER_DATA['employeeId'], $responseDTO->employeeId);
    }

    public function testGetCustomerByIdException(): void
    {
        $inputDto = GetCustomerByIdInputDTO::create(self::CUSTOMER_DATA['id']);

        $this->customerRepository
            ->expects($this->once())
            ->method('findOneByIdOrFail')
            ->with($inputDto->id)
            ->willThrowException(ResourceNotFoundException::createFromClassAndId(Customer::class, $inputDto->id));

        self::expectException(ResourceNotFoundException::class);

        $this->useCase->handle($inputDto);
    }
}