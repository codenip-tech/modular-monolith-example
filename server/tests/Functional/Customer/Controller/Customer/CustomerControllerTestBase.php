<?php

declare(strict_types=1);

namespace App\Tests\Functional\Customer\Controller\Customer;

use Employee\Entity\Employee;
use Employee\Repository\EmployeeRepository;
use Employee\Service\Security\PasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class CustomerControllerTestBase extends WebTestCase
{
    protected const CREATE_CUSTOMER_ENDPOINT = '/api/customers';
    protected const NON_EXISTING_CUSTOMER_ID = 'e0a1878f-dd52-4eea-959d-96f589a9f234';

    protected static ?AbstractBrowser $admin = null;

    public function setUp(): void
    {
        if (null === self::$admin) {
            self::$admin = static::createClient();
        }

        $admin = new Employee(Uuid::v4()->toRfc4122(), 'admin', 'admin@api.com');
        $password = static::getContainer()->get(PasswordHasherInterface::class)->hashPasswordForUser($admin, 'Password1!');
        $admin->setPassword($password);

        static::getContainer()->get(EmployeeRepository::class)->save($admin);

        $jwt = static::getContainer()->get(JWTTokenManagerInterface::class)->create($admin);

        self::$admin->setServerParameters([
            'CONTENT_TYPE' => 'application/json',
            'HTTP_Authorization' => \sprintf('Bearer %s', $jwt)
        ]);
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
            'email' => 'peter@api.com',
            'address' => 'Fake street 123',
            'age' => 30,
            'employeeId' => 'd368263a-ab71-4587-960d-cfe9725c373f',
        ];

        self::$admin->request(Request::METHOD_POST, self::CREATE_CUSTOMER_ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$admin->getResponse();

        if (Response::HTTP_CREATED !== $response->getStatusCode()) {
            throw new \RuntimeException('Error creating customer');
        }

        $responseData = $this->getResponseData($response);

        return $responseData['customerId'];
    }
}
