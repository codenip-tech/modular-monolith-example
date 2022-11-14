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

    public function execute(string $employeeId, int $page, int $limit, string $sort, string $order, ?string $name): array
    {
        $filter = '%s?employeeId=%s&page=%s&limit=%s&sort=%s&order=%s';

        if (null !== $name) {
            $filter .= '&name=%s';
        }

        $response = $this->httpClient->get(
            \sprintf(
                $filter,
                self::SEARCH_CUSTOMERS_ENDPOINT,
                $employeeId,
                $page,
                $limit,
                $sort,
                $order,
                $name
            )
        );

        return \json_decode($response->getBody()->getContents(), true, 512, \JSON_THROW_ON_ERROR);
    }
}
