<?php

declare(strict_types=1);

namespace Customer\Adapter\Framework\Http\Controller\Customer;

use Customer\Adapter\Framework\Http\DTO\GetCustomerByIdRequestDTO;
use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdInputDTO;
use Customer\Application\UseCase\Customer\GetCustomerById\GetCustomerById;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetCustomerByIdController extends AbstractController
{
    public function __construct(
        private readonly GetCustomerById $useCase
    ) {
    }

    #[Route('/{id}', name: 'get_customer_by_id', methods: ['GET'])]
    public function __invoke(GetCustomerByIdRequestDTO $request): Response
    {
        $responseDTO = $this->useCase->handle(GetCustomerByIdInputDTO::create($request->id));

        return new JsonResponse($responseDTO);
    }
}
