<?php

declare(strict_types=1);

namespace Employee\Service;

use Employee\Http\HttpClientInterface;

final class DeleteCustomerService
{
    private const DELETE_CUSTOMER_ENDPOINT = '/api/customers/%s';

    public function __construct(
        private readonly HttpClientInterface $httpClient
    ) {
    }

    public function delete(string $customerId): void
    {
        $this->httpClient->delete(\sprintf(self::DELETE_CUSTOMER_ENDPOINT, $customerId));
    }
}
