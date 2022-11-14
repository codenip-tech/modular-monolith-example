<?php

declare(strict_types=1);

namespace Customer\Adapter\Framework\Http\Controller\Customer;

use Customer\Adapter\Framework\Http\API\Filter\CustomerFilter;
use Customer\Adapter\Framework\Http\DTO\GetCustomersRequest;
use Customer\Application\UseCase\Customer\Search\SearchCustomers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SearchCustomerController extends AbstractController
{
    public function __construct(
        private readonly SearchCustomers $useCase
    ) {
    }

    #[Route('', name: 'search_customers', methods: ['GET'])]
    public function __invoke(GetCustomersRequest $request): Response
    {
        $filter = new CustomerFilter(
            $request->page,
            $request->limit,
            $request->employeeId,
            $request->sort,
            $request->order,
            $request->name
        );

        $output = $this->useCase->execute($filter);

        return $this->json($output->customers);
    }
}
