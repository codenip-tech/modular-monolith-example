<?php

declare(strict_types=1);

namespace Customer\Adapter\Framework\Http\Controller\Customer;

use Customer\Adapter\Framework\Http\DTO\CreateCustomerRequestDTO;
use Customer\Application\UseCase\Customer\CreateCustomer\CreateCustomer;
use Customer\Application\UseCase\Customer\CreateCustomer\DTO\CreateCustomerInputDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateCustomerController
{
    public function __construct(private readonly CreateCustomer $service)
    {
    }

    public function __invoke(CreateCustomerRequestDTO $request): Response
    {
        $responseDTO = $this->service->handle(CreateCustomerInputDTO::create($request->name, $request->address, $request->age, $request->employeeId));

        return new JsonResponse(['customerId' => $responseDTO->id], Response::HTTP_CREATED);
    }
}
