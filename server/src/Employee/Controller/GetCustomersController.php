<?php

declare(strict_types=1);

namespace Employee\Controller;

use Employee\Service\GetEmployeeCustomers;
use Employee\Service\Security\Voter\EmployeeVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetCustomersController extends AbstractController
{
    public function __construct(
        private readonly GetEmployeeCustomers $service
    ) {
    }

    #[Route('/{id}/customers', name: 'get_employee_customers', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $employeeId = $request->attributes->get('id');

        $this->denyAccessUnlessGranted(EmployeeVoter::GET_EMPLOYEE_CUSTOMERS, $employeeId);

        $customers = $this->service->execute($employeeId);

        return $this->json($customers);
    }
}
