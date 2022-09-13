<?php

declare(strict_types=1);

namespace Employee\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController extends AbstractController
{
    #[Route('/health-check', name: 'employee_health_check', methods: ['GET'], priority: 10)]
    public function __invoke(): Response
    {
        return $this->json(['message' => 'Module Employee up and running!']);
    }
}
