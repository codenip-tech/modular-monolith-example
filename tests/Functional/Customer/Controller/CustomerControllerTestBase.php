<?php

declare(strict_types=1);

namespace App\Tests\Functional\Customer\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\HttpFoundation\Response;

class CustomerControllerTestBase extends WebTestCase
{
    protected ?AbstractBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->setServerParameter('CONTENT_TYPE', 'application/json');
    }

    public function tearDown(): void
    {
        $this->client = null;
    }

    protected function getResponseData(Response $response): array
    {
        return (array) \json_decode($response->getContent(), true, 512, \JSON_THROW_ON_ERROR);
    }
}