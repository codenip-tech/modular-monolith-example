<?php

declare(strict_types=1);

namespace Customer\Adapter\Framework\Http\API\Filter;

final class CustomerFilter
{
    private const PAGE = 1;
    private const LIMIT = 10;

    public readonly int $page;
    public readonly int $limit;

    public function __construct(int $page, int $limit, public readonly string $employeeId)
    {
        if (0 !== $page) {
            $this->page = $page;
        } else {
            $this->page = self::PAGE;
        }

        if (0 !== $limit) {
            $this->limit = $limit;
        } else {
            $this->limit = self::LIMIT;
        }
    }
}
