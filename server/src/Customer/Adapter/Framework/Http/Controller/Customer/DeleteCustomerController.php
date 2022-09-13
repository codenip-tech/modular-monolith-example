<?php

declare(strict_types=1);

namespace Customer\Adapter\Framework\Http\Controller\Customer;

use Customer\Adapter\Framework\Http\DTO\DeleteCustomerRequestDTO;
use Customer\Application\UseCase\Customer\DeleteCustomer\DeleteCustomer;
use Customer\Application\UseCase\Customer\DeleteCustomer\DTO\DeleteCustomerInputDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteCustomerController extends AbstractController
{
    public function __construct(
        private readonly DeleteCustomer $useCase
    ) {
    }

    #[Route('/{id}', name: 'delete_customer', methods: ['DELETE'])]
    public function __invoke(DeleteCustomerRequestDTO $request): Response
    {
        $this->useCase->handle(DeleteCustomerInputDTO::create($request->id));

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
