<?php

declare(strict_types=1);

namespace Customer\Adapter\Framework\Http\Controller\Customer;

use Customer\Adapter\Framework\Http\DTO\UpdateCustomerRequestDTO;
use Customer\Application\UseCase\Customer\UpdateCustomer\DTO\UpdateCustomerInputDTO;
use Customer\Application\UseCase\Customer\UpdateCustomer\UpdateCustomer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UpdateCustomerController
{
    public function __construct(private readonly UpdateCustomer $useCase)
    {
    }

    public function __invoke(UpdateCustomerRequestDTO $request): Response
    {
        $inputDTO = UpdateCustomerInputDTO::create($request->id, $request->name, $request->address, $request->age, $request->keys);

        $responseDTO = $this->useCase->handle($inputDTO);

        return new JsonResponse($responseDTO->customerData);
    }
}
