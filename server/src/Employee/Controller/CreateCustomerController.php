<?php

declare(strict_types=1);

namespace Employee\Controller;

use Employee\Service\CreateCustomerService;
use Employee\Service\Security\Voter\EmployeeVoter;
use GuzzleHttp\Exception\ClientException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateCustomerController extends AbstractController
{
    public function __construct(
        private readonly CreateCustomerService $createCustomerService
    ) {
    }

    #[Route('/{id}/customers', name: 'create_employee_customer', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $employeeId = $request->attributes->get('id');

        $this->denyAccessUnlessGranted(EmployeeVoter::CREATE_CUSTOMER, $employeeId);

        $payload = \json_decode($request->getContent(), true);

        $name = $payload['name'];
        $email = $payload['email'];
        $address = $payload['address'];
        $age = (int) $payload['age'];

        try {
            $customerId = $this->createCustomerService->create($name, $email, $address, $age, $employeeId);

            return $this->json(['customerId' => $customerId], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            if ($e instanceof ClientException && 409 === $e->getResponse()->getStatusCode()) {
                return $this->json(['error' => $e->getMessage()], Response::HTTP_CONFLICT);
            }

            return $this->json(['error' => 'Internal server error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
