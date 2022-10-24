<?php

declare(strict_types=1);

namespace Employee\Service;

use Employee\Http\HttpClientInterface;

final class GetEmployeeCustomers
{
    private const SEARCH_CUSTOMERS_ENDPOINT = '/api/customers';

    public function __construct(
        private readonly HttpClientInterface $httpClient
    ) {
    }

    public function execute(string $employeeId): array
    {
        $response = $this->httpClient->get(\sprintf('%s?employeeId=%s', self::SEARCH_CUSTOMERS_ENDPOINT, $employeeId));

        return \json_decode($response->getBody()->getContents(), true, 512, \JSON_THROW_ON_ERROR);
    }
}
