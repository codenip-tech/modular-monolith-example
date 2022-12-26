<?php

declare(strict_types=1);

namespace Employee\Controller;

use Employee\Service\DeleteCustomerService;
use Employee\Service\Security\Voter\EmployeeVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteCustomerController extends AbstractController
{
    public function __construct(
        private readonly DeleteCustomerService $deleteCustomerService
    ) {
    }

    #[Route('/{id}/customers/{customerId}', name: 'employee_delete_customer', methods: ['DELETE'])]
    public function __invoke(Request $request): Response
    {
        $employeeId = $request->attributes->get('id');

        $this->denyAccessUnlessGranted(EmployeeVoter::DELETE_CUSTOMER, $employeeId);

        $customerId = $request->attributes->get('customerId');

        $this->deleteCustomerService->delete($customerId);

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
