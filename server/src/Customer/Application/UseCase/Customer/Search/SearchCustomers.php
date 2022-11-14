<?php

declare(strict_types=1);

namespace Customer\Application\UseCase\Customer\Search;

use Customer\Adapter\Framework\Http\API\Filter\CustomerFilter;
use Customer\Application\UseCase\Customer\Search\DTO\SearchCustomersOutput;
use Customer\Domain\Repository\CustomerRepository;

final class SearchCustomers
{
    public function __construct(
        private readonly CustomerRepository $customerRepository
    ) {
    }

    public function execute(CustomerFilter $filter): SearchCustomersOutput
    {
        $paginatedResponse = $this->customerRepository->search($filter);

        return SearchCustomersOutput::createFromPaginatedResponse($paginatedResponse);
    }
}
