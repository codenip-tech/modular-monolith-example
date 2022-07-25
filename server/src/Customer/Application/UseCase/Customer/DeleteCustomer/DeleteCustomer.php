<?php

declare(strict_types=1);

namespace Customer\Application\UseCase\Customer\DeleteCustomer;

use Customer\Application\UseCase\Customer\DeleteCustomer\DTO\DeleteCustomerInputDTO;
use Customer\Domain\Repository\CustomerRepository;

class DeleteCustomer
{
    public function __construct(
        private readonly CustomerRepository $customerRepository
    ) {
    }

    public function handle(DeleteCustomerInputDTO $dto): void
    {
        $customer = $this->customerRepository->findOneByIdOrFail($dto->id);

        $this->customerRepository->remove($customer);
    }
}
