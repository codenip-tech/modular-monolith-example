<?php

declare(strict_types=1);

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\DeleteCustomer;

use Customer\Application\UseCase\Customer\DeleteCustomer\DeleteCustomer;
use Customer\Application\UseCase\Customer\DeleteCustomer\DTO\DeleteCustomerInputDTO;
use Customer\Domain\Model\Customer;
use Customer\Domain\Repository\CustomerRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteCustomerTest extends TestCase
{
    private CustomerRepository|MockObject $customerRepository;

    private DeleteCustomer $useCase;

    public function setUp(): void
    {
        $this->customerRepository = $this->createMock(CustomerRepository::class);

        $this->useCase = new DeleteCustomer($this->customerRepository);
    }

    public function testDeleteCustomer(): void
    {
        $customerId = '37fb348b-891a-4b1c-a4e4-a4a68a3c6bae';

        $customer = Customer::create(
            $customerId,
            'Juan',
            'peter@api.com',
            'Fake street 123',
            30,
            '37fb348b-891a-4b1c-a4e4-a4a68a3c6111',
        );

        $inputDTO = DeleteCustomerInputDTO::create($customerId);

        $this->customerRepository
            ->expects($this->once())
            ->method('findOneByIdOrFail')
            ->with($customerId)
            ->willReturn($customer);

        $this->customerRepository
            ->expects($this->once())
            ->method('remove')
            ->with($customer);

        $this->useCase->handle($inputDTO);
    }
}
