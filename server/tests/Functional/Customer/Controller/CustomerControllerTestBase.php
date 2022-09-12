<?php

declare(strict_types=1);

namespace App\Tests\Functional\Customer\Controller;

use JsonException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerControllerTestBase extends WebTestCase
{
    protected const CREATE_CUSTOMER_ENDPOINT = '/api/customer/create';
    protected const NON_EXISTING_CUSTOMER_ID = 'e0a1878f-dd52-4eea-959d-96f589a9f234';

    protected static ?AbstractBrowser $client = null;

    public function setUp(): void
    {
        if (null === self::$client) {
            self::$client = static::createClient();
            self::$client->setServerParameter('CONTENT_TYPE', 'application/json');
        }
    }

    protected function getResponseData(Response $response): array
    {
        try {
            return \json_decode($response->getContent(), true);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    protected function createCustomer(): string
    {
        $payload = [
            'name' => 'Peter',
            'address' => 'Fake street 123',
            'age' => 30,
            'employeeId' => 'd368263a-ab71-4587-960d-cfe9725c373f',
        ];

        self::$client->request(Request::METHOD_POST, self::CREATE_CUSTOMER_ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$client->getResponse();

        if (Response::HTTP_CREATED !== $response->getStatusCode()) {
            throw new \RuntimeException('Error creating customer');
        }

        $responseData = $this->getResponseData($response);

        return $responseData['customerId'];
    }
}
