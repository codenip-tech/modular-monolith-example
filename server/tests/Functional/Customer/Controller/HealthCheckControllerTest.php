<?php

declare(strict_types=1);

namespace App\Tests\Functional\Customer\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HealthCheckControllerTest extends CustomerControllerTestBase
{
    private const ENDPOINT = '/api/customer/health-check';

    public function testCustomerHealthCheck(): void
    {
        self::$client->request(Request::METHOD_GET, self::ENDPOINT);

        $response = self::$client->getResponse();
        $responseData = $this->getResponseData($response);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertEquals('Module Customer up and running!', $responseData['message']);
    }
}