<?php

declare(strict_types=1);

namespace Customer\Application\UseCase\Customer\UpdateCustomer;

use Customer\Application\UseCase\Customer\UpdateCustomer\DTO\UpdateCustomerInputDTO;
use Customer\Application\UseCase\Customer\UpdateCustomer\DTO\UpdateCustomerOutputDTO;
use Customer\Domain\Repository\CustomerRepository;

class UpdateCustomer
{
    public function __construct(
        private readonly CustomerRepository $customerRepository
    ) {
    }

    public function handle(UpdateCustomerInputDTO $dto): UpdateCustomerOutputDTO
    {
        $customer = $this->customerRepository->findOneByIdOrFail($dto->id);

        $customer->setName($dto->name);
        $customer->setAddress($dto->address);
        $customer->setAge($dto->age);

        $this->customerRepository->save($customer);

        return UpdateCustomerOutputDTO::createFromModel($customer);
    }
}
