<?php

declare(strict_types=1);

namespace Customer\Application\UseCase\Customer\CreateCustomer;

use Customer\Application\UseCase\Customer\CreateCustomer\DTO\CreateCustomerInputDTO;
use Customer\Application\UseCase\Customer\CreateCustomer\DTO\CreateCustomerOutputDTO;
use Customer\Domain\Exception\CustomerAlreadyExistsException;
use Customer\Domain\Model\Customer;
use Customer\Domain\Repository\CustomerRepository;
use Customer\Domain\ValueObject\Uuid;

class CreateCustomer
{
    public function __construct(private readonly CustomerRepository $repository)
    {
    }

    public function handle(CreateCustomerInputDTO $dto): CreateCustomerOutputDTO
    {
        if (null !== $this->repository->findOneByEmail($dto->email)) {
            throw CustomerAlreadyExistsException::fromEmail($dto->email);
        }

        $customer = Customer::create(Uuid::random()->value(), $dto->name, $dto->email, $dto->address, $dto->age, $dto->employeeId);

        $this->repository->save($customer);

        return new CreateCustomerOutputDTO($customer->id());
    }
}
