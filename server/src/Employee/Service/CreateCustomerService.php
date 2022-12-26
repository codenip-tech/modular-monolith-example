<?php

declare(strict_types=1);

namespace Employee\Service;

use Employee\Http\HttpClientInterface;

final class CreateCustomerService
{
    private const CREATE_CUSTOMERS_ENDPOINT = '/api/customers';

    public function __construct(
        private readonly HttpClientInterface $httpClient
    ) {
    }

    public function create(string $name, string $email, string $address, int $age, string $employeeId): string
    {
        $payload = [
            'name' => $name,
            'email' => $email,
            'address' => $address,
            'age' => $age,
            'employeeId' => $employeeId,
        ];

        $response = $this->httpClient->post(
            self::CREATE_CUSTOMERS_ENDPOINT,
            ['json' => $payload]
        );

        $responseData = \json_decode($response->getBody()->getContents(), true, 512, \JSON_THROW_ON_ERROR);

        return $responseData['customerId'];
    }
}
