<?php

declare(strict_types=1);

namespace Customer\Adapter\Framework\Http\DTO;

use Symfony\Component\HttpFoundation\Request;

class CreateCustomerRequestDTO implements RequestDTO
{
    public readonly ?string $name;
    public readonly ?string $address;
    public readonly ?int $age;
    public readonly ?string $employeeId;

    public function __construct(Request $request)
    {
        $this->name = $request->request->get('name');
        $this->address = $request->request->get('address');
        $this->age = $request->request->get('age');
        $this->employeeId = $request->request->get('employeeId');
    }
}
