<?php

declare(strict_types=1);

namespace App\Tests\Functional\Customer\Controller\Customer;

use App\Tests\Functional\Customer\Controller\CustomerControllerTestBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteCustomerControllerTest extends CustomerControllerTestBase
{
    private const ENDPOINT = '/api/customer/%s';

    public function testDeleteCustomer(): void
    {
        $customerId = $this->createCustomer();

        self::$client->request(Request::METHOD_DELETE, \sprintf(self::ENDPOINT, $customerId));

        $response = self::$client->getResponse();

        self::assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteNonExistingCustomer(): void
    {
        self::$client->request(Request::METHOD_DELETE, \sprintf(self::ENDPOINT, self::NON_EXISTING_CUSTOMER_ID));

        $response = self::$client->getResponse();

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
