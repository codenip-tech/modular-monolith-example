<?php

declare(strict_types=1);

namespace Customer\Adapter\Framework\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HealthCheckController
{
    public function __invoke(): Response
    {
        return new JsonResponse(['message' => 'Module Customer up and running!']);
    }
}
