<?php

declare(strict_types=1);

namespace App\Tests\Functional\Customer\Controller\Customer;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateCustomerControllerTest extends CustomerControllerTestBase
{

    public function testCreateCustomerAndCheckIt(): void
    {
        $payload = [
            'name' => 'Peter',
            'email' => 'peter@api.com',
            'address' => 'Fake street 123',
            'age' => 30,
            'employeeId' => 'd368263a-ab71-4587-960d-cfe9725c373f',
        ];

        self::$admin->request(Request::METHOD_POST, CustomerControllerTestBase::CREATE_CUSTOMER_ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$admin->getResponse();
        $responseData = $this->getResponseData($response);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertArrayHasKey('customerId', $responseData);
        self::assertEquals(36, \strlen($responseData['customerId']));

        $generatedCustomerId = $responseData['customerId'];

        self::$admin->request(Request::METHOD_GET, \sprintf(self::CREATE_CUSTOMER_ENDPOINT . "/%s", $generatedCustomerId));

        $response = self::$admin->getResponse();
        $responseData = $this->getResponseData($response);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        self::assertArrayHasKey('id', $responseData);
        self::assertArrayHasKey('name', $responseData);
        self::assertArrayHasKey('email', $responseData);
        self::assertArrayHasKey('address', $responseData);
        self::assertArrayHasKey('age', $responseData);
        self::assertArrayHasKey('employeeId', $responseData);

        self::assertEquals($generatedCustomerId, $responseData['id']);
        self::assertEquals($payload['name'], $responseData['name']);
        self::assertEquals($payload['email'], $responseData['email']);
        self::assertEquals($payload['address'], $responseData['address']);
        self::assertEquals($payload['age'], $responseData['age']);
        self::assertEquals($payload['employeeId'], $responseData['employeeId']);
    }
}
