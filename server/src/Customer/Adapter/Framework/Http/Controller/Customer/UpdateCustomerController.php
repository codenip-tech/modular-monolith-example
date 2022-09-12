<?php

declare(strict_types=1);

namespace Customer\Adapter\Framework\Http\Controller\Customer;

use Customer\Adapter\Framework\Http\DTO\UpdateCustomerRequestDTO;
use Customer\Application\UseCase\Customer\UpdateCustomer\DTO\UpdateCustomerInputDTO;
use Customer\Application\UseCase\Customer\UpdateCustomer\UpdateCustomer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateCustomerController extends AbstractController
{
    public function __construct(private readonly UpdateCustomer $useCase)
    {
    }

    #[Route('/{id}', name: 'update_customer', methods: ['PATCH'])]
    public function __invoke(UpdateCustomerRequestDTO $request): Response
    {
        $inputDTO = UpdateCustomerInputDTO::create($request->id, $request->name, $request->email, $request->address, $request->age, $request->keys);

        $responseDTO = $this->useCase->handle($inputDTO);

        return new JsonResponse($responseDTO->customerData);
    }
}
