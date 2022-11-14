<?php

declare(strict_types=1);

namespace Customer\Adapter\Framework\Http\API\Response;

final class PaginatedResponse
{
    private function __construct(
        private readonly array $items,
        private readonly array $meta
    ) {
    }

    public static function create(array $items, int $total, int $page, int $limit): self
    {
        if (0 === $limit) {
            $lastPage = 0;
        } else {
            $lastPage = (int) \ceil($total / $limit);
        }

        $meta = [
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'hasNext' => $page < $lastPage,
        ];

        return new PaginatedResponse($items, $meta);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }
}
