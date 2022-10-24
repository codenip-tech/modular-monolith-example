<?php

declare(strict_types=1);

namespace Customer\Application\UseCase\Customer\Search\DTO;

use Customer\Adapter\Framework\Http\API\Response\PaginatedResponse;
use Customer\Domain\Model\Customer;

final class SearchCustomersOutput
{
    private function __construct(
        public readonly array $customers
    ) {
    }

    public static function createFromPaginatedResponse(PaginatedResponse $paginatedResponse): self
    {
        $items = \array_map(function (Customer $customer): array {
            return [
                'id' => $customer->id(),
                'name' => $customer->name(),
                'address' => $customer->address(),
            ];
        }, $paginatedResponse->getItems());

        $response['items'] = $items;
        $response['meta'] = $paginatedResponse->getMeta();

        return new SearchCustomersOutput($response);
    }
}
