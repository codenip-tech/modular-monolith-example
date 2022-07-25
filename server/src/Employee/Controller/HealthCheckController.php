<?php

declare(strict_types=1);

namespace Employee\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HealthCheckController
{
    public function __invoke(): Response
    {
        return new JsonResponse(['message' => 'Module Employee up and running!']);
    }
}
