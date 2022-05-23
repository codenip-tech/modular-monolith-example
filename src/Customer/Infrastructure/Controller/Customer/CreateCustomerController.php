<?php

declare(strict_types=1);

namespace Customer\Infrastructure\Controller\Customer;

use Customer\Application\CreateCustomer\CreateCustomer;
use Customer\Application\CreateCustomer\DTO\CreateCustomerInputDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateCustomerController
{
    public function __construct(private readonly CreateCustomer $service)
    {
    }

    public function __invoke(Request $request): Response
    {
        $data = \json_decode($request->getContent(), true);

        $responseDTO = $this->service->__invoke(CreateCustomerInputDTO::create($data['name'], $data['address'], $data['age'], $data['employeeId']));

        return new JsonResponse(['customerId' => $responseDTO->id], Response::HTTP_CREATED);
    }
}
