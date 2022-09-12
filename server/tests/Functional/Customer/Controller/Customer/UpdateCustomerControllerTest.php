<?php

declare(strict_types=1);

namespace App\Tests\Functional\Customer\Controller\Customer;

use App\Tests\Functional\Customer\Controller\CustomerControllerTestBase;
use Customer\Domain\Exception\ResourceNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateCustomerControllerTest extends CustomerControllerTestBase
{
    private const ENDPOINT = '/api/customers/%s';

    /**
     * @dataProvider updateCustomerDataProvider
     */
    public function testUpdateCustomer(array $payload): void
    {
        // create a customer
        $customerId = $this->createCustomer();
        // update a customer
        self::$client->request(Request::METHOD_PATCH, \sprintf(self::ENDPOINT, $customerId), [], [], [], \json_encode($payload));
        // checks
        $response = self::$client->getResponse();
        $responseData = $this->getResponseData($response);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $keys = \array_keys($payload);

        foreach ($keys as $key) {
            self::assertEquals($payload[$key], $responseData[$key]);
        }
    }

    public function testUpdateCustomerWithWrongValue(): void
    {
        $payload = ['name' => 'A'];

        $customerId = $this->createCustomer();

        self::$client->request(Request::METHOD_PATCH, \sprintf(self::ENDPOINT, $customerId), [], [], [], \json_encode($payload));

        $response = self::$client->getResponse();

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testUpdateNonExistingCustomer(): void
    {
        $payload = [
            'name' => 'Brian',
        ];

        self::$client->request(Request::METHOD_PATCH, \sprintf(self::ENDPOINT, self::NON_EXISTING_CUSTOMER_ID), [], [], [], \json_encode($payload));

        $response = self::$client->getResponse();
        $responseData = $this->getResponseData($response);

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        self::assertEquals(ResourceNotFoundException::class, $responseData['class']);
    }

    public function updateCustomerDataProvider(): iterable
    {
        yield 'Update name payload' => [
            [
                'name' => 'Brian',
            ],
        ];

        yield 'Update address payload' => [
            [
                'address' => 'New address 111',
            ],
        ];

        yield 'Update name and address payload' => [
            [
                'name' => 'Peter',
                'address' => 'New address 222',
            ],
        ];

        yield 'Update age payload' => [
            [
                'age' => 33,
            ],
        ];
    }
}
