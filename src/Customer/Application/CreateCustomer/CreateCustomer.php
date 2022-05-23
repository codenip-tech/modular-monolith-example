<?php

declare(strict_types=1);

namespace Customer\Application\CreateCustomer;

use Customer\Application\CreateCustomer\DTO\CreateCustomerInputDTO;
use Customer\Application\CreateCustomer\DTO\CreateCustomerOutputDTO;
use Customer\Domain\Model\Customer;
use Customer\Domain\Repository\CustomerRepository;
use Customer\Domain\ValueObject\Uuid;

class CreateCustomer
{
    public function __construct(private readonly CustomerRepository $repository)
    {
    }

    public function __invoke(CreateCustomerInputDTO $dto): CreateCustomerOutputDTO
    {
        $customer = new Customer(Uuid::random()->value(), $dto->name, $dto->address, $dto->age, $dto->employeeId);

        $this->repository->save($customer);

        return new CreateCustomerOutputDTO($customer->id());
    }
}
