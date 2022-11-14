<?php

declare(strict_types=1);

namespace Customer\Adapter\Framework\Http\DTO;

use Symfony\Component\HttpFoundation\Request;

final class GetCustomersRequest implements RequestDTO
{
    public readonly int $page;
    public readonly int $limit;
    public readonly ?string $employeeId;
    public readonly string $sort;
    public readonly string $order;
    public readonly ?string $name;

    public function __construct(Request $request)
    {
        $this->page = $request->query->getInt('page');
        $this->limit = $request->query->getInt('limit');
        $this->employeeId = $request->query->get('employeeId');
        $this->sort = $request->query->get('sort');
        $this->order = $request->query->get('order');
        $this->name = $request->query->get('name');
    }
}
