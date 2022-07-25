<?php

declare(strict_types=1);

namespace Customer\Application\UseCase\Customer\GetCustomerById;

use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdInputDTO;
use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdOutputDTO;
use Customer\Domain\Repository\CustomerRepository;

class GetCustomerById
{
    public function __construct(
        private readonly CustomerRepository $customerRepository
    ) {
    }

    public function handle(GetCustomerByIdInputDTO $dto): GetCustomerByIdOutputDTO
    {
        return GetCustomerByIdOutputDTO::create($this->customerRepository->findOneByIdOrFail($dto->id));
    }
}
