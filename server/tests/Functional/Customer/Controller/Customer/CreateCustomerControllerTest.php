<?php

declare(strict_types=1);

namespace App\Tests\Functional\Customer\Controller\Customer;

use App\Tests\Functional\Customer\Controller\CustomerControllerTestBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateCustomerControllerTest extends CustomerControllerTestBase
{
    private const ENDPOINT = '/api/customer/create';

    public function testCreateCustomerAndCheckIt(): void
    {
        $payload = [
            'name' => 'Peter',
            'address' => 'Fake street 123',
            'age' => 30,
            'employeeId' => 'd368263a-ab71-4587-960d-cfe9725c373f',
        ];

        self::$client->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$client->getResponse();
        $responseData = $this->getResponseData($response);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertArrayHasKey('customerId', $responseData);
        self::assertEquals(36, \strlen($responseData['customerId']));

        $generatedCustomerId = $responseData['customerId'];

        self::$client->request(Request::METHOD_GET, \sprintf('/api/customer/%s', $generatedCustomerId));

        $response = self::$client->getResponse();
        $responseData = $this->getResponseData($response);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        self::assertArrayHasKey('id', $responseData);
        self::assertArrayHasKey('name', $responseData);
        self::assertArrayHasKey('address', $responseData);
        self::assertArrayHasKey('age', $responseData);
        self::assertArrayHasKey('employeeId', $responseData);

        self::assertEquals($generatedCustomerId, $responseData['id']);
        self::assertEquals($payload['name'], $responseData['name']);
        self::assertEquals($payload['address'], $responseData['address']);
        self::assertEquals($payload['age'], $responseData['age']);
        self::assertEquals($payload['employeeId'], $responseData['employeeId']);
    }
}