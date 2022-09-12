<?php

declare(strict_types=1);

namespace Customer\Adapter\Framework\Http\Controller\Customer;

use Customer\Adapter\Framework\Http\DTO\CreateCustomerRequestDTO;
use Customer\Application\UseCase\Customer\CreateCustomer\CreateCustomer;
use Customer\Application\UseCase\Customer\CreateCustomer\DTO\CreateCustomerInputDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateCustomerController extends AbstractController
{
    public function __construct(private readonly CreateCustomer $service)
    {
    }

    #[Route('', name: 'create_customer', methods: ['POST'])]
    public function __invoke(CreateCustomerRequestDTO $request): Response
    {
        $responseDTO = $this->service->handle(CreateCustomerInputDTO::create($request->name, $request->address, $request->age, $request->employeeId));

        return new JsonResponse(['customerId' => $responseDTO->id], Response::HTTP_CREATED);
    }
}
