<?php

declare(strict_types=1);

namespace App\Tests\Functional\Customer\Controller\Customer;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteCustomerControllerTest extends CustomerControllerTestBase
{
    private const ENDPOINT = '/api/customers/%s';

    public function testDeleteCustomer(): void
    {
        $customerId = $this->createCustomer();

        self::$admin->request(Request::METHOD_DELETE, \sprintf(self::ENDPOINT, $customerId));

        $response = self::$admin->getResponse();

        self::assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteNonExistingCustomer(): void
    {
        self::$admin->request(Request::METHOD_DELETE, \sprintf(self::ENDPOINT, self::NON_EXISTING_CUSTOMER_ID));

        $response = self::$admin->getResponse();

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
