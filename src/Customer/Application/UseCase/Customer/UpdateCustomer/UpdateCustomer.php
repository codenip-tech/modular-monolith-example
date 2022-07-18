<?php

declare(strict_types=1);

namespace Customer\Application\UseCase\Customer\UpdateCustomer;

use Customer\Application\UseCase\Customer\UpdateCustomer\DTO\UpdateCustomerInputDTO;
use Customer\Application\UseCase\Customer\UpdateCustomer\DTO\UpdateCustomerOutputDTO;
use Customer\Domain\Repository\CustomerRepository;

class UpdateCustomer
{
    private const SETTER_PREFIX = 'set';

    public function __construct(
        private readonly CustomerRepository $customerRepository
    ) {
    }

    public function handle(UpdateCustomerInputDTO $dto): UpdateCustomerOutputDTO
    {
        $customer = $this->customerRepository->findOneByIdOrFail($dto->id);

        foreach ($dto->paramsToUpdate as $param) {
            $customer->{\sprintf('%s%s', self::SETTER_PREFIX, \ucfirst($param))}($dto->{$param});
        }

        $this->customerRepository->save($customer);

        return UpdateCustomerOutputDTO::createFromModel($customer);
    }
}
